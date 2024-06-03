<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\LogTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function home(): View
    {
        $last_result = LogTeam::latest()->first() ?? null;

        return view('welcome', [
            'user' => auth::user(),
            'last_result' => $last_result
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function dashboard(): View
    {
        return view('dashboard', [
            'players' => User::count(),
            'teams' => Team::count(),
        ]);
    }
}