<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteWord extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'word_id',
        'user_id'
    ];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
