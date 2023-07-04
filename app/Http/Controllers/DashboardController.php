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

        if (empty($shipmentMon[11])) {
            $shipmentMon[11] = []; // 初始化為空陣列
            for ($i = 0; $i < 6; $i++) {
                $shipmentMon[11][$i] = (object) [
                    'QTY' => 0,
                    'TYP_CODE' => $i,
                ];
            }
        }

        $shipmentThisMon = $shipmentMon[11];
        $total = 0;
        foreach ($shipmentThisMon as $key => $value) {
            $total += $value->QTY;
        }

        foreach ($shipmentThisMon as $key => $value) {
            if ($value->QTY == 0) {
                $value->part = 0;
            } else {
                $value->part = number_format(($value->QTY / $total) * 100, 1) . '%';
            }
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

        for ($i = 0; $i < count($shipmentRanking); $i++) {
            $item = $shipmentRanking[$i]->COD_ITEM;
            $lcst = DB::select("SELECT COD_ITEM, SUM(QTY_STK)AS QTY_STK FROM mes_lcst_item WHERE COD_ITEM = '$item' AND (COD_LOC = 'GO-001' OR COD_LOC = 'WO-003')");
            $shipmentRanking[$i]->QTY_STK = $lcst[0]->QTY_STK;
        }
        $todayDate = date('ymd');
        $maintenDate = 'MR' . date('ymd') . '%';
        $mainten = DB::select("SELECT * FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate'");



        $warranty = DB::select("SELECT PS1_4, COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN 20230527 and 20230627 AND (PS1_4 ='保固期內'OR PS1_4 ='保固期外') GROUP BY PS1_4");
        $total = 0;
        foreach ($warranty as $key => $value) {
            $total += $value->Count;
        };
        foreach ($warranty as $key => $value) {
            if ($value->Count == 0) {
                $value->part = 0;
            } else {
                $value->part = number_format(($value->Count / $total) * 100, 1) . '%';
            }
        }

        $warrantyPS = DB::select("SELECT MTRM_PS, COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN 20230527 and 20230627  GROUP BY MTRM_PS");

        $warrantyAll =  DB::select("SELECT COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN 20230527 and 20230627");

        $warrantyNO =  DB::select("SELECT MTRM_PS, COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN 20230527 and 20230627 AND (MTRM_PS ='NO') GROUP BY MTRM_PS");

        $warrantyPart[0] = (object) [
            'noDamage' => $warrantyNO[0]->Count,           
            'changeParts' => $warrantyAll[0]->Count - $warrantyNO[0]->Count,
            'noDamagePer' => number_format(($warrantyNO[0]->Count / $warrantyAll[0]->Count) * 100, 1) . '%',      
            'changePartsPer' => number_format((($warrantyAll[0]->Count - $warrantyNO[0]->Count) / $warrantyAll[0]->Count) * 100, 1) . '%'
        ];
        
        $borrowItem = DashboardModel::getBorrowItem();
        $unsalableProducts = DashboardModel::getUnsalableProducts();
        $productionStatus = DashboardModel::productionStatus($currentDate);
        return view('dashboardLeader', compact('productionStatus', 'borrowItem', 'unsalableProducts', 'shipmentMon', 'shipmentThisMon', 'shipmentRanking', 'mainten', 'warranty','warrantyPart'));
    }
}
