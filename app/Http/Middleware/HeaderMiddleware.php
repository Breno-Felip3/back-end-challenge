<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class HeaderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Inicia a contagem do tempo
        $startTime = microtime(true);
        // Gera uma chave dinâmica para o cache
        $cacheKey = md5($request->fullUrl());
    
        if (Cache::has($cacheKey)) 
        {
            $cacheStatus = 'HIT';
            $responseContent = Cache::get($cacheKey);
            // Cria uma nova resposta com o conteúdo do cache
            $response = response($responseContent);
        } 
        else 
        {
            $cacheStatus = 'MISS';
            //Obtem a resposta do Controller
            $response = $next($request);
            $responseContent = $response->getContent();
            // Armazena no cache
            Cache::put($cacheKey, $responseContent, 120);
        }
    
        // Transforma o tempo em ms
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);
        
        // Adiciona cabeçalhos
        $response->headers->set('x-cache', $cacheStatus);
        $response->headers->set('x-response-time', $responseTime . 'ms');
    
        return $response;
    }
}
