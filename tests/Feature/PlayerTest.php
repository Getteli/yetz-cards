<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
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

    public function test_player_page_is_displayed(): void
    {
        $player = User::factory()->create();

        $response = $this
            ->actingAs($player)
            ->get('/player/'.$player->id);

        $response->assertOk();
    }

    public function test_player_can_be_updated(): void
    {
        $player = User::factory()->create();

        $this
        ->actingAs($player)
        ->patch('/player/edit', [
            'id' => $player->id,
            'name' => 'Test User',
            'level' => 4,
            'is_goalkeeper' => true,
            'email' => 'test@example.com',
        ]);

        $player->refresh();

        $this->assertSame('Test User', $player->name);
    }

    public function test_player_can_delete_their_account_by_api(): void
    {
        $player = User::factory()->create();

        $this->delete('/api/player/delete/'.$player->id,[
            'id' => $player->id,
            'name' => $player->name,
            'is_active' => $player->is_active,
        ],['Authorization' => 'Bearer ' . $this->loginToTest()])->assertNoContent();
    }
}