<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;


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
            return response()->json($suerData);
        };
        return response()->json($employee_id);
    }
}
