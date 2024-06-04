<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogTeamRequest;
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
    public function index(): View
    {
        $results = LogTeam::orderBy('created_at','DESC')->get() ?? [];

        return view('team.results',[
            'results' => $results
        ]);
    }

    /**
     * Formulario para criar o resultado da partida da semana.
     */
    public function form(): view
    {
        $teams = Team::orderBy('name','ASC')->get() ?? [];

        return view('team.create-result',[
            'teams' => $teams
        ]);
    }

    /**
     * Metodo para criar o resultado da partida
     *
     * @param LogTeamRequest $request
     * @return RedirectResponse
     */
    public function create(LogTeamRequest $request): RedirectResponse
    {
        try
        {
            DB::beginTransaction();

            $result = (new LogTeam());
            $result->team1_id = $request->mandante;
            $result->score_team1 = $request->gols1;
            $result->team2_id = $request->visitor;
            $result->score_team2 = $request->gols2;
            $result->save();

            DB::commit();
            return Redirect::route('log_team.list');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('log_team.list')->with('status', 'Erro ao criar. Contacte o suporte');
        }
    }

    #region API

        /**
         * Listar os resultados das partidas - API.
         */
        public function apiIndex(Request $request): \Illuminate\Http\JsonResponse
        {
            
            $results = LogTeam::orderBy('created_at','DESC')->get() ?? [];

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
         * @param LogTeamRequest $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function apicreate(LogTeamRequest $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                DB::beginTransaction();

                $result = (new LogTeam());
                $result->team1_id = $request->mandante;
                $result->score_team1 = $request->gols1;
                $result->team2_id = $request->visitor;
                $result->score_team2 = $request->gols2;
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