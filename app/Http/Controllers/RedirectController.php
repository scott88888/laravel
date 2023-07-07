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
        $employeeId = auth()->user()->employee_id;
        if ($employeeId === 'user') {
            return redirect('/mesModelList');
        } else{
            return redirect('/dashboardLeader');
        }

       
    }
}
