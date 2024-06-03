<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $team1_id = $this->getRandomTeam();
        $team2_id = $this->getRandomTeam();

        if($team2_id == $team1_id)
        {
            $team2_id = $this->getRandomTeam($team1_id);
        }

        return [
            'team1_id' => $team1_id,
            'score_team1' => fake()->numberBetween(0,7),
            'team2_id' => $team2_id,
            'score_team2' => fake()->numberBetween(0,7),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    protected function getRandomTeam($not_id = null): int
    {
        if($not_id)
        {
            return Team::inRandomOrder()->where('id','!=',$not_id)->first(['id'])->id;
        }
        else
        {
            return Team::inRandomOrder()->first(['id'])->id;
        }
    }
}