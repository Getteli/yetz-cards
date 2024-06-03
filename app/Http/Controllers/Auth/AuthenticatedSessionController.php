<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    #region API

        /**
         * Realiza o login via API
         *
         * @param LoginRequest $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function apistore(LoginRequest $request): \Illuminate\Http\JsonResponse
        {
            $loginUserData = $request->all();

            $user = User::where('email',$loginUserData['email'])->first();

            if(!$user || !Hash::check($loginUserData['password'],$user->password)){
                return response()->json([
                    'message' => 'Credenciais inválidas'
                ],401);
            }

            $token = $user->createToken($user->name.'-apitoken')->plainTextToken;

            return response()->json([
                'token_type'   => 'Bearer',
                'access_token' => $token,
            ]);
        }

        /**
         * Realiza o logout via API
         *
         * @param Request $request
         * @return mixed
         */
        public function apidestroy(Request $request): mixed
        {
            auth()->user()->tokens()->delete();

            return response(null, 204);
        }
    #endregion
}
