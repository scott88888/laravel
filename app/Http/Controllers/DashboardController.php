<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\DashboardModel;
use DB;

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
        $BuyDelayDashboard = DashboardModel::getBuyDelayList();
        $year = date('Y', strtotime('-1 year')); 
        $month = date('Ym');   
        $lastMonth = date('Ym', strtotime('-1 month'));
        $RMAYearDashboard = DashboardModel::getRMAMonList($year);
        $RMAMonDashboard = DashboardModel::getRMAMonList($month);
        $RMALastMonDashboard = DashboardModel::getRMAMonList($lastMonth);
        
        


        return view('dashboardLeader', compact('MfrDashboard', 'ProductStockDashboard', 'PartsStockDashboard','BuyDelayDashboard','RMAYearDashboard','RMAMonDashboard','RMALastMonDashboard'));
    }
}
