<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveViteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();
            
            // Remove any script tags referencing @vite/client
            $content = preg_replace('/<script.*?@vite\/client.*?<\/script>/s', '', $content);
            
            // Remove any import statements for @vite/client
            $content = preg_replace('/import.*?@vite\/client.*?;/s', '', $content);
            
            $response->setContent($content);
        }
        
        return $response;
    }
}
