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
}
