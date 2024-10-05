<?php
namespace App\Repository;

use App\Models\FavoriteWord;
use App\Models\Word;
use App\Models\WordHistory;
use Illuminate\Support\Facades\Auth;

class WordRepository
{
    public function __construct(private Word $word, private WordHistory $wordHistory, private FavoriteWord $favoriteWord)
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

    public function getWord($word)
    {
        return $this->word->select("*")->where('word', $word)->first();
    }

    public function saveWordHistory($word)
    {
       $word = $this->getWord($word);
        if($word)
        {
            $user = Auth::user();

            $wordId = $word->id;
            $userId = $user->id;

            $accessHistory = [
                'word_id' => $wordId,
                'user_id' => $userId
            ];

            $register = $this->wordHistory->where('word_id', $wordId)->where('user_id', $userId)->first();
            if(! $register){
                $this->wordHistory->create($accessHistory);
            }
        }

        return $word;
    }

    public function saveFavoriteWord($word)
    {
        $word = $this->getWord($word);

        if($word)
        {
            $user = Auth::user();

            $wordId = $word->id;
            $userId = $user->id;

            $favoriteWord = [
                'word_id' => $wordId,
                'user_id' => $userId
            ];

            $register = $this->favoriteWord->where('word_id', $wordId)->where('user_id', $userId)->first();
            if(! $register){
                $this->favoriteWord->create($favoriteWord);
            }
        }

        return $word;
    }

    public function removeFavoriteWord($word)
    {
        $word = $this->getWord($word);

        if($word)
        {
            $user = Auth::user();

            $wordId = $word->id;
            $userId = $user->id;

            $this->favoriteWord->where('word_id', $wordId)->where('user_id', $userId)->delete();

            return 1;
        }

        return 0;
    }

    public function getHistoryByUser($limit, $page)
    {
        $user = Auth::user();
        return $user->wordHistories()->with('word')->paginate($limit, ["*"], 'page', $page);
    }

    public function getFavoritesByUser($limit, $page)
    {
        $user = Auth::user();
        return $user->favoriteWords()->with('word')->paginate($limit, ["*"], 'page', $page);
    }
}