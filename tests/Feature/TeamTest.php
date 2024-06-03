<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Realiza o login para testar os metodos
     *
     * @return string
     */
    private function loginToTest()
    {
        $user = User::factory()->create();

        return $user->createToken('api-token')->plainTextToken;
    }

    public function test_team_if_it_can_be_created(): void
    {
        $team = Team::factory()->create();

        expect($team)->toBeInstanceOf(Team::class);
    }

    public function test_team_page_is_displayed(): void
    {
        $team = Team::factory()->create();

        $this->get('/team/' . $team->id)->assertFound();
    }

    public function test_team_can_be_updated(): void
    {
        $team = Team::factory()->create();

        $this->post('/api/team/edit',[
            'id' => $team->id,
            'name' => $team->name,
            'is_active' => $team->is_active,
        ],['Authorization' => 'Bearer ' . $this->loginToTest()])->assertOk();
    }

    public function test_team_can_deleted_by_api(): void
    {
        $team = Team::factory()->create();

        $this->delete('/api/team/delete/'.$team->id,[
            'id' => $team->id,
            'name' => $team->name,
            'is_active' => $team->is_active,
        ],['Authorization' => 'Bearer ' . $this->loginToTest()])->assertNoContent();
    }
}
