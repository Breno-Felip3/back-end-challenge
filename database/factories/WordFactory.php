<?php

namespace Database\Factories;

use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
   
    protected $model = Word::class;

    public function definition(): array
    {
        return [
            'word' => $this->faker->word()
        ];
    }
}
