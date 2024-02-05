<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Illuminate\Support\Facades\Auth;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (Auth::check()) {
            $user = Auth::user();
            $employee_id = $user->employee_id;
            $browserLanguage = DB::select("SELECT * 
        FROM mes_check_permission
        WHERE employee_id = '$employee_id'");
            if (count($browserLanguage) == 0) {
                app()->setLocale('zh');
            } elseif ($browserLanguage[0]->lang_default) {
                app()->setLocale($browserLanguage[0]->lang_default);
            } else {
                $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                app()->setLocale($browserLanguage);
            }
        } else {
            $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            app()->setLocale($browserLanguage);
        }



        // // 獲取瀏覽器的語言
        // $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        // // 根據瀏覽器的語言設置應用程序的語言
        // if ($browserLanguage === 'zh') {
        //     // 如果瀏覽器語言是中文，設置應用程序語言為中文
        //     app()->setLocale('zh');
        // } else {
        //     // 否則，使用默認語言（例如英文）
        //     app()->setLocale('en');
        // }

        return $next($request);
    }
}
