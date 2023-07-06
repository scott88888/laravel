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

       

        //過去12個月出貨數量//當月
        $shipmentMon = $this->shipmentMon();
        $shipmentThisMon = $shipmentMon['shipmentThisMon'];
        $shipmentMon = $shipmentMon['shipmentMon'];
        //end

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


        //今日生產維修狀況
        $maintenData = $this->mainten();
        //今日生產維修狀況end

        $warrantyDateE = date('Ymd');
        $warrantyDateS = date('Ymd', strtotime('-30 days', strtotime(date('Ymd'))));

        $warranty = DB::select("SELECT PS1_4, COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE AND (PS1_4 ='保固期內'OR PS1_4 ='保固期外') GROUP BY PS1_4");
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
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE  GROUP BY MTRM_PS");

        $warrantyAll =  DB::select("SELECT COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE");

        $warrantyNO =  DB::select("SELECT MTRM_PS, COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE AND (MTRM_PS ='NO') GROUP BY MTRM_PS");

        $warrantyPart[0] = (object) [
            'noDamage' => $warrantyNO[0]->Count,
            'changeParts' => $warrantyAll[0]->Count - $warrantyNO[0]->Count,
            'noDamagePer' => number_format(($warrantyNO[0]->Count / $warrantyAll[0]->Count) * 100, 1) . '%',
            'changePartsPer' => number_format((($warrantyAll[0]->Count - $warrantyNO[0]->Count) / $warrantyAll[0]->Count) * 100, 1) . '%'
        ];

        $repairQuantity = DB::select("SELECT COUNT(*) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE and  PS1_2 <> '測試正常' ");

        $AVGtime = DB::select("SELECT AVG(DIFF_DAYS) AS Count
        FROM mes_rma_analysis
        WHERE DAT_ONCA BETWEEN $warrantyDateS and $warrantyDateE");

        $borrowItem = DashboardModel::getBorrowItem();
        $unsalableProducts = DashboardModel::getUnsalableProducts();
        $productionData = $this->productionStatus();
        $description = $this->description();

        return view('dashboardLeader', compact('productionData', 'borrowItem', 'unsalableProducts', 'shipmentMon', 'shipmentThisMon', 'shipmentRanking', 'maintenData', 'warranty', 'warrantyPart', 'repairQuantity', 'AVGtime','description'));
    }


    public function productionStatus()
    {
        $currentDate = date('Y-m-d');
        $productionStatus = DashboardModel::productionStatus($currentDate);
        if (count($productionStatus) === 0) {
            $data = DB::select("SELECT startTime FROM runcard ORDER BY `id` DESC LIMIT 1");
            $currentDate = substr($data[0]->startTime, 0, 10);
            $productionStatus = DashboardModel::productionStatus($currentDate);
        }
        $currentDate = substr($currentDate, 2);
        return ['productionStatus' => $productionStatus, 'currentDate' => $currentDate];
    }

    public function mainten()
    {
        $maintenDate = 'MR' . date('ymd');
        $mainten = DB::select("SELECT * FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate%'");
        if (count($mainten) === 0) {
            $data = DB::select("SELECT * FROM runcard_ng_rate ORDER BY ng_id DESC LIMIT 1");
            $maintenDate = substr($data[0]->num_comr, 0, -4);
            $mainten = DB::select("SELECT * FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate%'");
        }
        $maintenDate = substr($maintenDate, 2, 2) . '-' . substr($maintenDate, 4, 2) . '-' . substr($maintenDate, 6, 2);
        return ['mainten' => $mainten, 'maintenDate' => $maintenDate];
    }

    public function shipmentMon()
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


        return ['shipmentMon' => $shipmentMon, 'shipmentThisMon' => $shipmentThisMon];
    }

    public function description()
    {

        $description = DB::select("SELECT
                                        a.sts_comr,
                                        c.description AS comr_desc,
                                        COUNT(c.description) AS count_comr
                                    FROM
                                        runcard_ng_rate AS a
                                        LEFT JOIN defective AS c ON a.sts_comr = c.item_no
                                    WHERE
                                    (num_comr >= 'MR2306010001')  AND (num_comr <= 'MR2307010001')
                                    GROUP BY
                                    comr_desc
                                    ORDER BY
                                    count_comr DESC
                                    LIMIT 10
                                    ");
        //var_dump($description);
        $total = 0;
        foreach ($description as $key => $value) {
            $total +=  $value->count_comr;
        }       
        foreach ($description as $key => $value) {
            $value->count_comr = number_format(($value->count_comr / $total)* 100, 1). '%';           
        }
        return $description;
    }
}
