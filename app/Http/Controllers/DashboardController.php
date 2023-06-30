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
        //取得時間
        $currentDate = date('Y-m-d');

        $currentYear = date('Y', strtotime($currentDate));
        $currentMonth = date('m', strtotime($currentDate));
        $recentMonths = array();
        for ($i = 0; $i < 12; $i++) {
            $year = $currentYear;
            $month = $currentMonth - $i;
            if ($month <= 0) {
                $year--;
                $month = 12 + $month;
            }
            $formattedMonth = sprintf("%02d", $month);
            $recentMonths[11 - $i] = $year . $formattedMonth;
        }

        for ($i = 0; $i < 12; $i++) {
            $day1 = $recentMonths[$i] . '01';
            $day31 = $recentMonths[$i] . '31';
            $shipmentMon[] = DashboardModel::getShipmentMon($day1, $day31);
        }
        $shipmentThisMon = $shipmentMon[11];
        $total = 0;
        foreach ($shipmentThisMon as $key => $value) {
            $total += $value->QTY;
        }
        foreach ($shipmentThisMon as $key => $value) {
            $value->part = number_format(($value->QTY / $total) * 100, 1) . '%';
        }

        
        $shipmentRanking = DB::select("SELECT subquery.NAM_ITEMS, subquery.QTY_DEL, subquery.TYP_ITEM, subquery.TYP_CODE, subquery.COD_ITEM
        FROM (
          SELECT mes_deld_shipment.NAM_ITEMS, SUM(mes_deld_shipment.QTY_DEL) AS QTY_DEL, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM,
            ROW_NUMBER() OVER (PARTITION BY mes_typ_item.TYP_CODE ORDER BY SUM(mes_deld_shipment.QTY_DEL) DESC) AS row_num
          FROM mes_deld_shipment
          LEFT JOIN mes_typ_item ON mes_deld_shipment.TYP_ITEM = mes_typ_item.TYP_ITEM
          WHERE mes_deld_shipment.DAT_DEL >= '20230401' AND mes_deld_shipment.DAT_DEL <= '20230631'
          GROUP BY mes_deld_shipment.NAM_ITEMS, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM
        ) AS subquery
        WHERE subquery.row_num <= 2
        ORDER BY subquery.TYP_CODE, subquery.QTY_DEL DESC");

        for ($i=0; $i < count($shipmentRanking); $i++) { 
            $item = $shipmentRanking[$i]->COD_ITEM;            
            $lcst = DB::select("SELECT COD_ITEM, SUM(QTY_STK)AS QTY_STK FROM mes_lcst_item WHERE COD_ITEM = '$item' AND (COD_LOC = 'GO-001' OR COD_LOC = 'WO-003')");
            $shipmentRanking[$i] -> QTY_STK = $lcst[0]->QTY_STK;
        }
        $todayDate = date('ymd');
        $maintenDate = 'MR'.date('ymd').'%';
        $mainten = DB::select("SELECT * FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate' ");
       


        // $shipment = DB::select("SELECT subquery.NAM_ITEMS, subquery.QTY_DEL, subquery.TYP_ITEM, subquery.TYP_CODE, subquery.COD_ITEM
        // FROM (
        //   SELECT mes_deld_shipment.NAM_ITEMS, SUM(mes_deld_shipment.QTY_DEL) AS QTY_DEL, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM,
        //     ROW_NUMBER() OVER (PARTITION BY mes_typ_item.TYP_CODE ORDER BY SUM(mes_deld_shipment.QTY_DEL) DESC) AS row_num
        //   FROM mes_deld_shipment
        //   LEFT JOIN mes_typ_item ON mes_deld_shipment.TYP_ITEM = mes_typ_item.TYP_ITEM
        //   WHERE mes_deld_shipment.DAT_DEL >= '20230601' AND mes_deld_shipment.DAT_DEL <= '20230631'
        //   GROUP BY mes_deld_shipment.NAM_ITEMS, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM
        // ) AS subquery
        // WHERE subquery.row_num <= 10
        // ORDER BY subquery.TYP_CODE, subquery.QTY_DEL DESC;
        // ;
        // ");
        // exit;
        $borrowItem = DashboardModel::getBorrowItem();
        $unsalableProducts = DashboardModel::getUnsalableProducts();
        $productionStatus = DashboardModel::productionStatus($currentDate);
        return view('dashboardLeader', compact('productionStatus', 'borrowItem', 'unsalableProducts', 'shipmentMon', 'shipmentThisMon','shipmentRanking','mainten'));
    }
}
