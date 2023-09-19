<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

use DB;
use Illuminate\Http\Request;

class TestController extends BaseController
{

    public function test()
    {
        $pythonScriptPath = 'C:\xampp\htdocs\test\3DBinPacking\pallet.py';

        $arg = " -t sea -c W1103D800 -b W620D315H520 -o /USR/OUTPUT/IMAGES";
        $output = exec("C:\Users\AI007\AppData\Local\Programs\Python\Python311\python.exe $pythonScriptPath $arg");
        echo $output; 
    }
}
