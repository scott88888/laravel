<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            $url = $request->path(); 
            $time = now(); 

            
            DB::table('mes_loginlog')->insert([
                'id' => '',
                'user_name' => $user->name,                
                'user_id' => $user->employee_id,
                'log_url' => $url,
                'log_time' => $time,
            ]);
        }
       
        return $response;
    }
}
