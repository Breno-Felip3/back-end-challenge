<?php

namespace Database\Factories;

use App\Models\FavoriteWord;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteWordFactory extends Factory
{
   
    protected $model = FavoriteWord::class;

    public function definition(): array
    {
        return [
            'word_id' => Word::factory(),
            'user_id' => User::factory()
        ];
    }
}
