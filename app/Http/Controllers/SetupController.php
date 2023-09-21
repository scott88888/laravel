<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

use DB;
use Illuminate\Http\Request;

class SetupController extends BaseController
{

    public function userLoginLog()
    {

        $value = DB::table('mes_loginlog')
            ->orderBy('id', 'desc')
            ->get();
        return view('userLoginLog', compact('value'));
    }

    public function userCheckPermission()
    {

        return view('userCheckPermission');
    }
    public function userSearchIDAjax(Request $request)
    {

        $employee_id = $request->input('searchID');
        if ($employee_id) {
            $suerData =  DB::select("SELECT *
                FROM mes_check_permission
                WHERE employee_id = '$employee_id'");

            if (!empty($suerData)) {
                return response()->json($suerData);
            } else {
                return response()->json(['error' => '查無資料'], 404);
            }
        }

        return response()->json(['error' => '查無資料'], 400);
    }

    public function userUpdatePermissionAjax(Request $request)
    {
        $employee_id = $request->input('searchID');
        $pageID = $request->input('selectedCheckboxIds');
        $default = $request->input('default');
        $pageIDAsString = implode(',', $pageID);


        if ($employee_id && $pageID) {
            // 先刪除現有的記錄
            DB::table('mes_check_permission')->where('employee_id', $employee_id)->delete();
            // 插入新記錄
            $insert = DB::table('mes_check_permission')->insert([
                'employee_id' => $employee_id,
                'permission' => $pageIDAsString,
                'default' => $pageID[0]
            ]);
            if ($insert) {
                return response()->json(['success' => true, 'message' => '權限更新成功']);
            } else {
                return response()->json(['success' => false, 'message' => '權限更新失敗']);
            }
        }
        return response()->json($pageID);
    }

    public function userEdit()
    {
        $userEdit=DB::select("SELECT 
                                    U.name,U.employee_id,U.email,
                                    LENGTH(M.permission COLLATE utf8_general_ci) - LENGTH(REPLACE(M.permission COLLATE utf8_general_ci, ',', '')) + 1 AS number_count
                                FROM mes_check_permission M
                                INNER JOIN users U ON M.employee_id = U.employee_id COLLATE utf8_general_ci;");
        return view('userEdit', compact('userEdit'));
    }
}
