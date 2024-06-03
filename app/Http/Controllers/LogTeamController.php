<?php

namespace App\Http\Controllers;

use App\Models\LogTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LogTeamController extends Controller
{
    /**
     * Listar os resultados das partidas.
     */
    public function index(Request $request): View
    {
        $results = LogTeam::all() ?? [];

        return view('team.results',[
            'results' => $results
        ]);
    }

    /**
     * Formulario para criar o resultado da partida da semana.
     */
    public function form(): view
    {
        return view('team.create-result');
    }

    /**
     * Metodo para criar o resultado da partida
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

    #region API

        /**
         * Listar os resultados das partidas - API.
         */
        public function apiIndex(Request $request): \Illuminate\Http\JsonResponse
        {
            
            $results = LogTeam::all() ?? [];

            if($results)
            {
                return response()->json($results->load(['principal','visitor'])->toArray());
            }
            else
            {
                return response()->json(['message'=>'Nenhum resultado encontrado']);
            }
        }

        /**
         * Metodo para criar o resultado da partida - API
         *
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function apicreate(Request $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                $players = $request->player;

                DB::beginTransaction();

                $result = (new Team());
                $result->name = "Time ";
                $result->is_active = true;
                $result->save();

                DB::commit();

                return response()->json($result->toArray());
            }
            catch (\Throwable $th)
            {
                return response()->json(['message'=>'Erro ao criar. Contacte o suporte']);
            }
        }

    #endregion
}