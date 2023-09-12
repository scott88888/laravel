<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

use DB;
use Illuminate\Http\Request;

class SidebarController extends BaseController
{

    public function sidebarPageAjax(Request $request)
    {
        $user = Auth::user();
        $user->employee_id;
        $permissionPage = DB::select("SELECT * 
            FROM `mes_check_permission`
            WHERE `employee_id` = '$user->employee_id';");

        $permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,26,27,28";
        $permissionsArray = explode(',', $permission);
        $pageNames = [];

        foreach ($permissionsArray as $permissionId) {
            $page = DB::table('mes_all_page')
                ->where('id', $permissionId)
                ->value('name');

            if ($page) {
                $pageNames[] = $page;
            }
        }
        return response()->json($pageNames);
    }
}
