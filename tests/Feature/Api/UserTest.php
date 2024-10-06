<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Word;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_me(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/user/me/');

        $response->assertStatus(200);
    }

    public function test_user_me_history(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $word = Word::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/entries/en/' . $word->word);

        $response->assertStatus(200);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/user/me/history');

        $response->assertStatus(200);
    }

    public function test_user_me_favorites(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $word = Word::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/entries/en/'. $word->word .'/favorite');

        $response->assertStatus(200);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/user/me/favorites');

        $response->assertStatus(200);
    }
}