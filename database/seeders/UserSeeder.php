<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        User::factory(16)->create();

        User::factory()->create([
            'name' => 'Douglas',
            'email' => 'douglas@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'level' => 4,
            'is_goalkeeper' => 0,
        ]);
	}
}
