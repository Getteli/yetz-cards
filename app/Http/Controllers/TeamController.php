<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function open($id): RedirectResponse
    {
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function update(Request $request): RedirectResponse
    {
        return Redirect::to('/');
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
}