<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $players = (new User())->all() ?? [];

        return view('player.list', [
            'players' => $players,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function open($id): view
    {
        $player = (new User())->where('id', $id)->first() ?? [];

        return view('player.edit', [
            'player' => $player,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(PlayerUpdateRequest $request): RedirectResponse
    {
        try
        {
            $request->prepareForValidation();

            $player = (new User())->where('id', $request->id)->first();
            $player->fill($request->validated());
            $player->save();

            return Redirect::route('player.open',['id' => $request->id])->with('status', 'Jogador atualizado com sucesso!');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('player.open',['id' => $request->id])->with('status', 'Erro ao atualizar. Contacte o suporte');
        }
    }

    /**
     * Delete the user's account.
     */
    public function create(Request $request): RedirectResponse
    {
        try
        {
            $request->merge([
                'is_goalkeeper' => $request->is_goalkeeper == "on" ? 1 : 0,
                'password' => Hash::make(mt_rand(1000000,99999999))
            ]);

            $player = User::create($request->all());

            return Redirect::route('player.open',['id' => $player->id])->with('status', 'Jogador criado com sucesso!');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('player.form')->with('status', 'Erro ao criar. Contacte o suporte');
        }
    }

    /**
     * Delete the user's account.
     */
    public function form(): view
    {
        return view('player.create');
    }

    /**
     * Delete the user's account.
     */
    public function delete($id): RedirectResponse
    {
        $player = User::where('id',$id)->first();

        $player->delete();

        // retoma para a listagem
        $players = (new User())->all() ?? [];

        return Redirect::route('player.list', [
            'players' => $players,
        ]);
    }
}