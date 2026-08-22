<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Impede indexacao por qualquer buscador (enquanto o projeto nao estiver em uso real).
// Aplica o cabecalho a todas as respostas, inclusive PDFs e conteudos nao-HTML.
class NoIndex
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (method_exists($response, 'header')) {
            $response->header('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
        }
        return $response;
    }
}
