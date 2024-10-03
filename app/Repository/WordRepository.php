<?php
namespace App\Repository;

use App\Models\Word;

class WordRepository
{
    public function __construct(private Word $word)
    {}

    public function getWords($limit, $page = 1, $search = "")
    {
        $words = $this->word->select('word')->where(function($query) use ($search){
            if ($search != "") {
                $query->where('word', 'LIKE', "%$search%");
            }
        })
        ->orderBy('word')
        ->paginate($limit, ["*"], 'page', $page);

        return $words;
    }
}