<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasTeamSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $players = User::all();

        foreach ($players as $key => $player)
        {
            DB::table('user_has_team')->insert([
                'presence'  => mt_rand(0,1),
                'user_id'   => User::inRandomOrder()->first(['id'])->id,
                'team_id'   => Team::inRandomOrder()->first(['id'])->id,
            ]);
        }
	}
}
