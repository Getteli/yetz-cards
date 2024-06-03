<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Recupera os dados do usuario logado em tela
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Atualizar perfil do usuario logado
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try
        {
            $request->prepareForValidation();

            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();
            
            return Redirect::route('profile.edit')->with('status', 'Perfil atualizado com sucesso');
        }
        catch (\Throwable $th)
        {
            return Redirect::route('profile.edit')->with('status', 'Erro ao atualizar. Contacte o suporte');
        }
    }

    /**
     * Excluir conta do usuario logado
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    #region API

        /**
         * recupera os dados do usuario logado - API
         *
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function apiProfile(Request $request): \Illuminate\Http\JsonResponse
        {
            // Get current user
            $user = auth::user();

            return response()->json($user->toArray());
        }

        /**
         * Atualizar perfil do usuario logado - API
         *
         * @param Request $request
         * @return RedirectResponse
         */
        public function apiUpdate(Request $request): \Illuminate\Http\JsonResponse
        {
            try
            {
                $request->merge([
                    'is_goalkeeper' => $request->is_goalkeeper == "1" ? 1 : 0,
                ]);

                $request->user()->fill($request->all());

                if ($request->user()->isDirty('email')) {
                    $request->user()->email_verified_at = null;
                }

                $request->user()->save();
                
                return response()->json($request->user()->toArray());
            }
            catch (\Throwable $th)
            {
                return response()->json([
                    // 'message' => 'Erro ao atualizar. Contacte o suporte'
                    'message' => $th->getMessage()
                ]);
            }
        }

        /**
         * Excluir conta do usuario logado
         *
         * @param Request $request
         * @return RedirectResponse
         */
        public function apiDestroy(Request $request): mixed
        {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            auth()->user()->delete();
            auth()->user()->tokens()->delete();

            return response(null, 204);
        }

    #endregion
}