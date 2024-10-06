<?php

namespace Tests\Feature\Api;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Word;
use Tests\TestCase;

class EntriesTest extends TestCase
{
    public function test_get_words(): void
    {
        //Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/entries/en');

        // Verifica se a resposta é a esperada
        $response->assertStatus(200);
    }

    public function test_get_word_save_history(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Cria uma palavra no banco de dados
        $word = Word::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/entries/en/' . $word->word);

        $response->assertStatus(200);
    }

    public function test_get_word_not_found(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $word = "not found";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/entries/en/' . $word);

        $response->assertStatus(400);
    }

    public function test_post_word_save_favorite(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $word = Word::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/entries/en/'. $word->word .'/favorite');

        $response->assertStatus(200);
    }

    public function test_post_word_save_favorite_not_found(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $word = 'not found';

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/entries/en/'. $word .'/favorite');

        $response->assertStatus(400);
    }

    public function test_delete_word_unfavorite(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        $word = Word::factory()->create();
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/entries/en/' . $word->word . '/favorite');
    
        $response->assertStatus(200);
    
        // Faz a requisição para desfavoritar a palavra
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/entries/en/' . $word->word . '/unfavorite');
    
        $response->assertStatus(204);
    }

    public function test_delete_word_unfavorite_not_found(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/entries/en/' . 'not found' . '/unfavorite');

        $response->assertStatus(400);
    }
}
