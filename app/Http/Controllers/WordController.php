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
        $results = $words->pluck('word');

        return $this->returnPaginate($words, $results);
    }

    public function show(Request $request, $word)
    {
        //Realiza um hash da url completa
        $cacheKey = md5($request->fullUrl());
        $word = $this->wordRepository->saveWordHistory($word, $cacheKey);

        if(! $word){
            return response()->json(["message" => "Not Found"], 400);
        }

        return [
            'results' => $word
        ];
    }

    public function favoriteWord($word)
    {
        $word = $this->wordRepository->saveFavoriteWord($word);

        if(! $word){
            return response()->json(["message" => "Not Found"], 400);
        }

        return [
            'results' => $word
        ];
    }

    public function removeFavoriteWord($word)
    {
        $response = $this->wordRepository->removeFavoriteWord($word);
        
        if($response == 1){
            return response()->json(["message" => "Not Content"], 204);
        }
        return response()->json(["message" => "Not Found"], 400);
    }

    public function historyByUser(Request $request)
    {
        $limit = $request->limit ?? 5;
        $page = $request->page ?? 1;

        $histories = $this->wordRepository->getHistoryByUser($limit, $page);
        $results = WordResource::collection($histories->pluck('word'));

        return $this->returnPaginate($histories, $results);
    }

    public function favoritesByUser(Request $request)
    {
        $limit = $request->limit ?? 5;
        $page = $request->page ?? 1;

        $favorites = $this->wordRepository->getFavoritesByUser($limit, $page);
        $results =  WordResource::collection($favorites->pluck('word'));

        return $this->returnPaginate($favorites, $results);
    }

    public function returnPaginate($data, $results)
    {
        return [
            'results' => $results, 
            'totalDocs' => $data->total(), 
            'page' => $data->currentPage(), 
            'totalPages' => $data->lastPage(), 
            'hasNext' => $data->hasMorePages(), 
            'hasPrev' => $data->currentPage() > 1, 
        ];
    }
}