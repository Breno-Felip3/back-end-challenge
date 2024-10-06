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
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Faz a requisição para a API, enviando a palavra gerada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/user/me/');

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);
    }

    public function test_user_me_history(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Cria uma palavra no banco de dados
        $word = Word::factory()->create();

        // Faz a requisição para a API, enviando a palavra gerada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/entries/en/' . $word->word);

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/user/me/history');

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);
    }

    public function test_user_me_favorites(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Cria uma palavra no banco de dados
        $word = Word::factory()->create();

        // Faz a requisição para a API, enviando a palavra gerada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/entries/en/'. $word->word .'/favorite');

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/user/me/favorites');

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);
    }
}
