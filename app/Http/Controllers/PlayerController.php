<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerUpdateRequest;
use App\Http\Resources\PlayerResource;
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
     * Listar players.
     */
    public function index(): View
    {
        $players = User::orderBy('created_at','DESC')->get() ?? [];

        return view('player.list', [
            'players' => $players,
        ]);
    }

    /**
     * Pegar informações de um player pelo id.
     */
    public function open($id): view
    {
        $player = (new User())->where('id', $id)->first() ?? [];

        return view('player.edit', [
            'player' => $player,
        ]);
    }

    /**
     * Atualizar player.
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
     * cria um novo player.
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
     * Form para criar player.
     */
    public function form(): view
    {
        return view('player.create');
    }

    /**
     * Delete player.
     */
    public function delete($id): RedirectResponse
    {
        $player = User::where('id',$id)->first();

        $player->delete();

        // retoma para a listagem
        $players = User::orderBy('created_at','DESC')->get() ?? [];

        return Redirect::route('player.list', [
            'players' => $players,
        ]);
    }

    #region API

        /**
         * Listar players. - API
         */
        public function apiIndex(Request $request): PlayerResource
        {
            $players = User::orderBy('created_at','DESC')->get() ?? [];

            return new PlayerResource($players);
        }

        /**
         * Pegar informações de um player pelo id. - API
         */
        public function apiOpen($id): \Illuminate\Http\JsonResponse
        {
            $player = (new User())->where('id', $id)->first() ?? [];

            if($player)
            {
                return response()->json($player->toArray());
            }
            else
            {
                return response()->json(['message'=>'Jogador não encontrado']);
            }
        }

        /**
         * Atualizar player. - API
         */
        public function apiUpdate(Request $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                $request->merge([
                    'is_goalkeeper' => $request->is_goalkeeper == "true" ? 1 : 0,
                ]);

                $player = (new User())->where('id', $request->id)->first();
                $player->fill($request->all());
                $player->save();

                return response()->json($player->toArray());
            }
            catch (\Throwable $th)
            {
                return response()->json(['message'=>'Erro ao atualizar. Contacte o suporte']);
            }
        }

        /**
         * cria um novo player. - API
         */
        public function apiCreate(Request $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                $request->merge([
                    'is_goalkeeper' => $request->is_goalkeeper == "1" ? 1 : 0,
                    'password' => Hash::make(mt_rand(1000000,99999999))
                ]);

                $player = User::create($request->all());

                return response()->json($player->toArray());
            }
            catch (\Throwable $th)
            {
                return response()->json(['message'=>'Erro ao criar. Contacte o suporte']);
            }
        }

        /**
         * Delete player. - API
         */
        public function apiDelete($id): mixed
        {
            $player = User::where('id',$id)->first();

            if($player)
            {
                $player->delete();

                return response(null, 204);
            }
            else
            {
                return response()->json(['message'=>'Jogador não encontrado']);
            }
        }

    #endregion
}