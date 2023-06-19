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

        // $MfrDashboard = DashboardModel::getMfrList();
        // $ProductStockDashboard = DashboardModel::getProductStockList();
        // $PartsStockDashboard = DashboardModel::getPartsStockList();
        // $BuyDelayDashboard = DashboardModel::getBuyDelayList();
        // $year = date('Y', strtotime('-1 year')); 
        // $month = date('Ym');   
        // $lastMonth = date('Ym', strtotime('-1 month'));
        // $RMAYearDashboard = DashboardModel::getRMAMonList($year);
        // $RMAMonDashboard = DashboardModel::getRMAMonList($month);
        // $RMALastMonDashboard = DashboardModel::getRMAMonList($lastMonth);
        

        $productionStatus = $this->productionStatus();
        //var_dump($productionStatus);
        return view('dashboardLeader', compact('productionStatus'));
    }


    function productionStatus(){
        $value = DB::select("SELECT *, COUNT(*) AS count
        FROM (
            SELECT tmp1.`runcard_no`, tmp1.`work_no`, tmp1.`version`, tmp1.`startTime`, tmp1.`NUM_PS`, tmp1.`COD_MITEM`, tmp1.`productionLine`, tmp1.`operation`, tmp2.remark2, tmp2.num_po, tmp2.qty_pcs
            FROM runcard tmp1, order_this_month tmp2
            WHERE tmp1.`startTime` LIKE '2023-06-19%'
              AND tmp1.`NUM_PS` = tmp2.`num_ps`
            GROUP BY tmp1.runcard_no
        ) AS temp_table
        GROUP BY work_no
        ORDER BY `startTime` DESC");
        return $value;


    }
}
