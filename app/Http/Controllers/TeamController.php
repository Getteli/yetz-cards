<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Listar os times.
     */
    public function index(Request $request): View
    {
        $teams = Team::orderBy('created_at','DESC')->get() ?? [];

        return view('team.list',[
            'teams' => $teams
        ]);
    }

    /**
     * Abrir informações de um time pelo id.
     */
    public function open($id): view
    {
        $team = (new Team())->where('id', $id)->with('users')->first() ?? [];

        return view('team.edit', [
            'team' => $team,
        ]);
    }

    /**
     * Atualizar dados do time.
     */
    public function update(Request $request): RedirectResponse
    {
        try
        {
            $request->merge([
                'is_active' => $request->is_active ? 1 : 0,
            ]);

            $team = (new Team())->where('id', $request->id)->first();
            $team->fill($request->all());
            $team->save();
            
            return Redirect::route('team.open',['id'=>$team->id])->with('status', 'Time atualizado com sucesso');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('team.open',['id'=>$team->id])->with('status', 'Erro ao atualizar. Contacte o suporte');
        }
    }

    /**
     * Formulario para criar uma partida.
     */
    public function form(): view
    {
        $players = User::orderBy('created_at','DESC')->get() ?? [];

        return view('team.create',[
            'players' => $players
        ]);
    }

    /**
     * Metodo para criar uma partida
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        try
        {
            $players = $request->player;
            foreach ($players as $key => $values)
            {
                $valores = explode(',', $values);
                $players[$key] = [
                    'id' => $valores[0],
                    'level' => $valores[1],
                ];
            }

            $qtd_players_total = count($players);
            $nj = $request->nj; // por time
            $qtd_times = intdiv($qtd_players_total,$nj); // qtd de times que será criado
            $ultimo_time = $qtd_players_total%$nj; // se sobrar, a qtd de jogadores no ultimo time

            // se o número total de confirmados seja menor que Nj*2,
            if($qtd_players_total < $nj*2)
            {
                return Redirect::route('team.form')->with('status', 'Não é permitido criar a partida quando o numero de jogadores é maior que a quantidade de jogadores confirmados');
            }

            /**
             * equilibrar o time pelo nivel dos jogadores,
             * 1° ordena pelo level do menor para o maior
             * depois reordena para equilibrar os times
             * A lógica escolhida é: colocar um de maior nivel com o menor nivel, intercalados
             */
            usort($players, function ($a, $b) {
                return $a['level'] - $b['level'];
            });

            // agora equilibra entre o maior e o menor
            for ($i = 0; $i < count($players) / 2; $i++)
            {
                $players_ordenado[] = $players[$i];
                $players_ordenado[] = $players[count($players) - 1 - $i];
            }
            $players = $players_ordenado;

            DB::beginTransaction();

            // cria os times
            for ($team_i=1; $team_i <= $qtd_times; $team_i++)
            {
                $newteam = (new Team());
                $newteam->name = "Time " . $team_i;
                $newteam->is_active = true;
                $newteam->save();

                // adiciona os jogadores no time
                $jogadores_notime = 0;
                $has_goleiro = false;
                foreach ($players as $key => $player)
                {
                    // se ja tive no maximo, para
                    if($jogadores_notime >= $nj) break;

                    // verifica se o jogador é goleiro
                    $playerdb = User::find($player['id']);
                    // é goleiro mas o time ainda não tem
                    if($playerdb->is_goalkeeper && !$has_goleiro)
                    {
                        $has_goleiro = true;
                    }
                    // é goleiro e o time já tem
                    elseif($has_goleiro && $playerdb->is_goalkeeper)
                    {
                        continue;
                    }

                    $newteam->users()->attach($player['id'], [
                        'presence' => true
                    ]);

                    $jogadores_notime++;
                    // remove o jogador da list para o proximo time
                    unset($players[$key]);
                }
            }

            if($ultimo_time)
            {
                // cria o time com os jogadores restantes
                $time_restante = (new Team());
                $time_restante->name = "time " . $team_i++;
                $time_restante->is_active = true;
                $time_restante->save();

                $jogadores_notime = 0;
                $has_goleiro = false;
                foreach ($players as $key => $player)
                {
                    // se ja tive no maximo, para
                    if($jogadores_notime >= $nj) break;

                    // verifica se o jogador é goleiro
                    $playerdb = User::find($player['id']);
                    // é goleiro mas o time ainda não tem
                    if($playerdb->is_goalkeeper && !$has_goleiro)
                    {
                        $has_goleiro = true;
                    }
                    // é goleiro e o time já tem
                    elseif($has_goleiro && $playerdb->is_goalkeeper)
                    {
                        continue;
                    }

                    $time_restante->users()->attach($player['id'], [
                        'presence' => true
                    ]);

                    $jogadores_notime++;
                    // remove o jogador da list para o proximo time
                    unset($players[$key]);
                }
            }

            DB::commit();
            return Redirect::route('team.list');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('team.form')->with('status', 'Erro ao criar. Contacte o suporte');
        }
    }

    /**
     * Excluir um time
     */
    public function delete($id): RedirectResponse
    {
        $team = Team::where('id',$id)->first();

        DB::table('user_has_team')
            ->where('team_id',$id)
            ->delete();

        $team->delete();

        // retoma para a listagem
        $teams = Team::orderBy('created_at','DESC')->get() ?? [];

        return Redirect::route('team.list', [
            'teams' => $teams,
        ]);
    }

    #region API

        /**
         * Listar os times.
         */
        public function apiIndex(Request $request): \Illuminate\Http\JsonResponse
        {
            $teams = Team::orderBy('created_at','DESC')->get() ?? [];

            return response()->json($teams->load('users')->toArray());
        }

        /**
         * Abrir informações de um time pelo id.
         */
        public function apiOpen($id): \Illuminate\Http\JsonResponse
        {
            $team = (new Team())->where('id', $id)->with('users')->first() ?? [];

            if($team)
            {
                return response()->json($team->load('users')->toArray());
            }
            else
            {
                return response()->json(['message'=>'Time não encontrado']);
            }
        }

        /**
         * Atualizar dados do time.
         */
        public function apiUpdate(Request $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                $request->merge([
                    'is_active' => $request->is_active ? 1 : 0,
                ]);

                $team = (new Team())->where('id', $request->id)->first();
                $team->fill($request->all());
                $team->save();
                
                return response()->json($team->load('users')->toArray());
            }
            catch (\Throwable $th)
            {
                return response()->json(['message'=>'Erro ao atualizar. Contacte o suporte']);
            }
        }

        /**
         * Metodo para criar uma partida
         *
         * @param Request $request
         * @return mixed
         */
        public function apiCreate(Request $request): mixed
        {
            try
            {
                $players = explode(";",$request->player);
                foreach ($players as $key => $values)
                {
                    $valores = explode(',', $values);
                    $players[$key] = [
                        'id' => $valores[0],
                        'level' => $valores[1],
                    ];
                }

                $qtd_players_total = count($players);
                $nj = $request->nj; // por time
                $qtd_times = intdiv($qtd_players_total,$nj); // qtd de times que será criado
                $ultimo_time = $qtd_players_total%$nj; // se sobrar, a qtd de jogadores no ultimo time

                // se o número total de confirmados seja menor que Nj*2,
                if($qtd_players_total < $nj*2)
                {
                    return response()->json(['message', 'Não é permitido criar a partida quando o numero de jogadores é maior que a quantidade de jogadores confirmados']);
                }

                /**
                 * equilibrar o time pelo nivel dos jogadores,
                 * 1° ordena pelo level do menor para o maior
                 * depois reordena para equilibrar os times
                 * A lógica escolhida é: colocar um de maior nivel com o menor nivel, intercalados
                 */
                usort($players, function ($a, $b) {
                    return $a['level'] - $b['level'];
                });

                // agora equilibra entre o maior e o menor
                for ($i = 0; $i < count($players) / 2; $i++)
                {
                    $players_ordenado[] = $players[$i];
                    $players_ordenado[] = $players[count($players) - 1 - $i];
                }
                $players = $players_ordenado;

                DB::beginTransaction();

                // cria os times
                for ($team_i=1; $team_i <= $qtd_times; $team_i++)
                {
                    $newteam = (new Team());
                    $newteam->name = "Time " . $team_i;
                    $newteam->is_active = true;
                    $newteam->save();

                    // adiciona os jogadores no time
                    $jogadores_notime = 0;
                    $has_goleiro = false;
                    foreach ($players as $key => $player)
                    {
                        // se ja tive no maximo, para
                        if($jogadores_notime >= $nj) break;

                        // verifica se o jogador é goleiro
                        $playerdb = User::find($player['id']);
                        // é goleiro mas o time ainda não tem
                        if($playerdb->is_goalkeeper && !$has_goleiro)
                        {
                            $has_goleiro = true;
                        }
                        // é goleiro e o time já tem
                        elseif($has_goleiro && $playerdb->is_goalkeeper)
                        {
                            continue;
                        }

                        $newteam->users()->attach($player['id'], [
                            'presence' => true
                        ]);

                        $jogadores_notime++;
                        // remove o jogador da list para o proximo time
                        unset($players[$key]);
                    }
                }

                if($ultimo_time)
                {
                    // cria o time com os jogadores restantes
                    $time_restante = (new Team());
                    $time_restante->name = "time " . $team_i++;
                    $time_restante->is_active = true;
                    $time_restante->save();

                    $jogadores_notime = 0;
                    $has_goleiro = false;
                    foreach ($players as $key => $player)
                    {
                        // se ja tive no maximo, para
                        if($jogadores_notime >= $nj) break;

                        // verifica se o jogador é goleiro
                        $playerdb = User::find($player['id']);
                        // é goleiro mas o time ainda não tem
                        if($playerdb->is_goalkeeper && !$has_goleiro)
                        {
                            $has_goleiro = true;
                        }
                        // é goleiro e o time já tem
                        elseif($has_goleiro && $playerdb->is_goalkeeper)
                        {
                            continue;
                        }

                        $time_restante->users()->attach($player['id'], [
                            'presence' => true
                        ]);

                        $jogadores_notime++;
                        // remove o jogador da list para o proximo time
                        unset($players[$key]);
                    }
                }

                DB::commit();

                return response(null,201);
            }
            catch (\Throwable $th)
            {
                return response()->json(['message', 'Erro ao criar. Contacte o suporte']);
            }
        }

        /**
         * Excluir um time
         */
        public function apiDelete($id): mixed
        {
            $team = Team::where('id',$id)->first();

            if($team)
            {
                DB::table('user_has_team')
                ->where('team_id',$id)
                ->delete();

                $team->delete();

                return response(null, 204);
            }
            else
            {
                return response()->json(['message'=>'Time não encontrado']);
            }

        }
    #endregion
}