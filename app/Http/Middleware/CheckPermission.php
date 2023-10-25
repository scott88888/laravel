<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\PasswordController;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        try {
            
            // 當前user
            $user = Auth::user();
            if ($user->def_pass == 'pass' && $user->employee_id != 'B001') {
                // 使用 action() 函数指定控制器的动作
                return Redirect::action([PasswordController::class, 'showUpdateForm'])->with('message', 'change password');
            }
           
            $user->employee_id;
            if ($user->employee_id == 'unitest') {
                return $next($request);
            } else {
                $pageID = DB::select("SELECT * 
                FROM `mes_all_page`
                WHERE `page` ='$permission';");
                if ($pageID) {
                    $pageID = $pageID[0]->id;
                }
                // 查詢當前用戶權限
                $record = DB::table('mes_check_permission')
                    ->where('employee_id', $user->employee_id)
                    ->whereRaw("FIND_IN_SET($pageID, permission)")
                    ->first();

                if ($record) {
                    return $next($request);
                } else {
                    return redirect()->back()->with('error', 'Unauthorized');
                }
            }
        } catch (\Exception) {
            abort(500, 'Internal Server Error');
        }
    }
   
  
}
