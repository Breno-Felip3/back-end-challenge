<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'word'
    ];

    public function favoriteWords()
    {
        return $this->hasMany(FavoriteWord::class);
    }

    public function wordHistories()
    {
        return $this->hasMany(WordHistory::class);
    }
    
}
