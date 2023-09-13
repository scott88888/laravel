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
        $dbData = DB::select("SELECT * 
        FROM `mes_all_page`;");
        $dbIds = array_column($dbData, 'id');
        $permissionPage = DB::select("SELECT * 
            FROM `mes_check_permission`
            WHERE `employee_id` = '$user->employee_id';");

        $permission = $permissionPage[0]->permission;
        $permissionArray = explode(',', $permission);
        $diffIds = array_diff($dbIds, $permissionArray);


        $pageNames = [];

        foreach ($diffIds as $permissionId) {
            $page = DB::table('mes_all_page')
                ->where('id', $permissionId)
                ->value('page');

            if ($page) {
                $pageNames[] = $page;
            }
        }
        return response()->json($pageNames);
    }
}
