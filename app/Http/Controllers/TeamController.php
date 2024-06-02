<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $teams = Team::all() ?? [];

        return view('team.list',[
            'teams' => $teams
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function open($id): view
    {
        $team = (new Team())->where('id', $id)->first() ?? [];

        return view('team.edit', [
            'team' => $team,
        ]);
    }

    /**
     * Delete the user's account.
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
     * Delete the user's account.
     */
    public function form(): view
    {
        return view('team.form');
    }

    /**
     * Delete the user's account.
     */
    public function create(Request $request): RedirectResponse
    {
        return Redirect::to('/');
    }

    /**
     * Delete the user's account.
     */
    public function delete($id): RedirectResponse
    {
        $team = Team::where('id',$id)->first();

        DB::table('user_has_team')
            ->where('team_id',$id)
            ->delete();

        $team->delete();

        // retoma para a listagem
        $teams = (new Team())->all() ?? [];

        return Redirect::route('team.list', [
            'teams' => $teams,
        ]);
    }
}