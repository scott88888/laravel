<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // 獲取瀏覽器的語言

         $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

         // 根據瀏覽器的語言設置應用程序的語言
         if ($browserLanguage === 'zh') {
             // 如果瀏覽器語言是中文，設置應用程序語言為中文
             app()->setLocale('zh');
         } else {
             // 否則，使用默認語言（例如英文）
             app()->setLocale('en');
         }
    
         return $next($request);
    }
}
