<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;


use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class DealerController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $langService;
    public function Dealer(Request $request)
    {
        
        return view('dealerLogin');
       
    }
}
