<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Hash;
use Illuminate\Http\Request;
use App\Models\DashboardModel;

class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request)
    {
        return view('Dashboard');
    }
    public function dashboardLeader(Request $request)
    {       
        $MfrDashboard = DashboardModel::getMfrList();
        $ProductStockDashboard = DashboardModel::getProductStockList();
        $PartsStockDashboard = DashboardModel::getPartsStockList();
        return view('dashboardLeader', compact('MfrDashboard', 'ProductStockDashboard', 'PartsStockDashboard'));
    }
}
