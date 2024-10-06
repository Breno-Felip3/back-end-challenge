<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Word;
use App\Models\WordHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WordHistory>
 */
class wordHistoryFactory extends Factory
{
    protected $model = WordHistory::class;

    public function definition(): array
    {
        return [
            'word_id' => Word::factory(),
            'user_id' => User::factory()
        ];
    }
}
