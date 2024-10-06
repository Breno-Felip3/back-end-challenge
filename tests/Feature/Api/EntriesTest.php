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

        $response->assertStatus(200);
    }

    public function test_get_word_save_history(): void
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
    }

    public function test_get_word_not_found(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $word = "not found";

        // Faz a requisição para a API, enviando a palavra gerada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->getJson('/api/entries/en/' . $word);

        // Verifica se a resposta é a esperada
        $response->assertStatus(400);
    }

    public function test_post_word_save_favorite(): void
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

        // verifica se a palavra foi salva nos favoritos
        $this->assertDatabaseHas('favorite_words', [
            'user_id' => $user->id,
            'word_id' => $word->id,
        ]);
    }

    public function test_post_word_save_favorite_not_found(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Cria uma palavra no banco de dados
        $word = 'not found';

        // Faz a requisição para a API, enviando a palavra gerada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/entries/en/'. $word .'/favorite');

        // Verifica se a resposta é a esperada
        $response->assertStatus(400);
    }

    public function test_delete_word_unfavorite(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        // Cria uma palavra no banco de dados
        $word = Word::factory()->create();
    
        // Faz a requisição para a API, enviando a palavra gerada, para favoritar a palavra
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/entries/en/' . $word->word . '/favorite');
    
        // Verifica se a resposta é a esperada
        $response->assertStatus(200);
    
        // Verifica se a palavra foi salva nos favoritos
        $this->assertDatabaseHas('favorite_words', [
            'user_id' => $user->id,
            'word_id' => $word->id,
        ]);
    
        // Faz a requisição para desfavoritar a palavra
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/entries/en/' . $word->word . '/unfavorite');
    
        // Verifica se a resposta é a esperada
        $response->assertStatus(204);
    
        // Verifica se a palavra foi removida dos favoritos
        $this->assertDatabaseMissing('favorite_words', [
            'user_id' => $user->id,
            'word_id' => $word->id,
        ]);
    }

    public function test_delete_word_unfavorite_not_found(): void
    {
        // Cria um usuário, gera e envia token de autenticação
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        // Faz a requisição para desfavoritar a palavra
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/entries/en/' . 'not found' . '/unfavorite');
    
        // Verifica se a resposta é a esperada
        $response->assertStatus(400);
    }
}
