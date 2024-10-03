<?php

namespace App\Http\Controllers;

use App\Repository\WordRepository;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function __construct(private WordRepository $wordRepository)
    {}

    public function index(Request $request)
    {
        $limit = $request->limit ?? 5;
        $page = $request->page ?? 1;
        $search = $request->search ?? "";

        $words = $this->wordRepository->getWords($limit, $page, $search); 
        
        return [
            'results' => $words->pluck('word'), 
            'totalDocs' => $words->total(), 
            'page' => $words->currentPage(), 
            'totalPages' => $words->lastPage(), 
            'hasNext' => $words->hasMorePages(), 
            'hasPrev' => $words->currentPage() > 1, 
        ];
    }

    public function show($word)
    {
        $word = $this->wordRepository->wordHistory($word);

        if(! $word){
            return response()->json(["message" => "Not Found"], 400);
        }

        return [
            'results' => $word
        ];
    }

    public function favoriteWord($word)
    {
        $word = $this->wordRepository->favoriteWord($word);

        if(! $word){
            return response()->json(["message" => "Not Found"], 400);
        }

        return [
            'results' => $word
        ];
    }

    public function removeFavoriteWord($word)
    {
        $this->wordRepository->removeFavoriteWord($word);
    }
}
