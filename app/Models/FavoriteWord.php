<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteWord extends Model
{
    use HasFactory;

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
