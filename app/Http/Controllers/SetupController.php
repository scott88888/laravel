<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;


use DB;
use Illuminate\Http\Request;

class SetupController extends BaseController
{
    
    public function userLoginLog()
    {
        return view('userLoginLog');
    }
}
