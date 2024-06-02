<?php

namespace Database\Seeders;

use App\Models\LogTeam;
use Illuminate\Database\Seeder;

class LogTeamSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        LogTeam::factory(5)->create();
	}
}
