<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        try {
            // 當前user
            $user = Auth::user();
            $user->employee_id;
        
            $pageID = DB::select("SELECT * 
                FROM `mes_all_page`
                WHERE `page` ='$permission';");
            
            if ($pageID) {
                $pageID = $pageID[0]->id;
            }
        
            // 查询当前用户具有权限访问的页面
            $record = DB::table('mes_check_permission')
            ->where('employee_id', $user->employee_id)
            ->whereRaw("FIND_IN_SET($pageID, permission)")
            ->first();
       

            if ($record) {
                return $next($request);
            } else {               
                return redirect()->back()->with('error', 'Unauthorized');
            }
        
          
        } catch (\Exception ) {
            // 处理异常，例如记录错误或返回自定义错误响应
            // 你可以根据需要处理不同类型的异常
         
            abort(500, 'Internal Server Error');
        }
        
        
    }
}
