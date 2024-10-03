<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
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
}
