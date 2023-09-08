<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MesModelList;


use DB;
use Illuminate\Http\Request;

class RedirectController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    public function redirect(Request $request)
    {
        //導向預設頁面
        $employeeId = auth()->user()->employee_id;
            $pageInfo = DB::table('mes_check_permission')
                ->join('mes_all_page', 'mes_check_permission.default', '=', 'mes_all_page.id')
                ->where('mes_check_permission.employee_id', $employeeId)
                ->select('mes_all_page.*')
                ->first();
        if ($pageInfo) {                    
            return redirect('/'.$pageInfo->page);
        } else {
            return redirect('/dashboardLeader');
        }
       
    }
}
