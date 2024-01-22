<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\DashboardModel;
use DB;
use App\Services\LangService;


class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }

    public function dashboardLeader(Request $request)
    {
        //過去12個月出貨數量//當月
        $shipmentMon = $this->shipmentMon();
        $shipmentThisMon = $shipmentMon['shipmentThisMon'];
        $shipmentMon = $shipmentMon['shipmentMon'];
        //end
        $seasonDates = $this->getPreviousSeasonDates();
 
        $startSeasonDate = $seasonDates['start'];
        $endSeasonDate = $seasonDates['end'];
        $seasonDates['Season'] = substr($seasonDates['start'], 0, 6) . '-' . substr($seasonDates['end'], 0, 6);
 
        $shipmentRanking = DB::select("SELECT subquery.NAM_ITEMS, subquery.QTY_DEL, subquery.TYP_ITEM, subquery.TYP_CODE, subquery.COD_ITEM
        FROM (
          SELECT mes_deld_shipment.NAM_ITEMS, SUM(mes_deld_shipment.QTY_DEL) AS QTY_DEL, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM,
            ROW_NUMBER() OVER (PARTITION BY mes_typ_item.TYP_CODE ORDER BY SUM(mes_deld_shipment.QTY_DEL) DESC) AS row_num
          FROM mes_deld_shipment
          LEFT JOIN mes_typ_item ON mes_deld_shipment.TYP_ITEM = mes_typ_item.TYP_ITEM
          WHERE mes_deld_shipment.DAT_DEL >= '$startSeasonDate' AND mes_deld_shipment.DAT_DEL <= '$endSeasonDate'
          GROUP BY mes_deld_shipment.NAM_ITEMS, mes_deld_shipment.TYP_ITEM, mes_typ_item.TYP_CODE, mes_deld_shipment.COD_ITEM
        ) AS subquery
        WHERE subquery.row_num <= 2
        ORDER BY subquery.TYP_CODE, subquery.QTY_DEL DESC");

        for ($i = 0; $i < count($shipmentRanking); $i++) {
            $item = $shipmentRanking[$i]->COD_ITEM;
            $lcst = DB::select("SELECT COD_ITEM, SUM(QTY_STK) AS QTY_STK
            FROM (
                SELECT COD_ITEM, SUM(QTY_STK) AS QTY_STK
                FROM mes_lcst_item
                WHERE COD_ITEM = '$item'
                GROUP BY COD_ITEM
            
                UNION ALL
            
                SELECT COD_ITEM, SUM(QTY_STK) AS QTY_STK
                FROM mes_lcst_parts
                WHERE COD_ITEM = '$item'
                GROUP BY COD_ITEM
            ) AS CombinedResults
            GROUP BY COD_ITEM;");
            $shipmentRanking[$i]->QTY_STK = $lcst[0]->QTY_STK;
        }



        //今日生產維修狀況
        $maintenData = $this->mainten();
        //今日生產維修狀況end
        $lastMonthFirstDay = date('ym01', strtotime('first day of last month'));
        $lastMonthLastDay = date('ymd', strtotime('last day of last month'));
        $warrantyDateS = 'FB' . $lastMonthFirstDay . '0000';
        $warrantyDateE = 'FB' . $lastMonthLastDay . '9999';
        $targetDateTime = \DateTime::createFromFormat('ymd', $lastMonthLastDay);
        $firstDayOfPrevious13Months = $targetDateTime->sub(new \DateInterval('P13M'))->modify('first day of this month');
        $thirteenMonthsAgoNumber = $firstDayOfPrevious13Months->format('ymd');

        // $lastMonthLastDay = date('ym') . '999999';
        // $thirteenMonthsAgoNumber = date('ym', strtotime('-13 months')) . '000000';


        //維修總數
        // $warrantyCount = DB::select("SELECT COUNT(*) AS result_count
        // FROM mes_rma_analysis
        // WHERE NUM_MTRM BETWEEN '$thirteenMonthsAgoNumber AND $lastMonthLastDay'");

        $warrantyCount = DB::select("SELECT COUNT(*) AS result_count
                                    FROM mes_rma_analysis
                                    WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'");

        //維修保固外
        $warrantyCountOut = DB::select("SELECT COUNT(*) AS result_count
                                        FROM mes_rma_analysis
                                        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                                        AND NUM_SER NOT BETWEEN '$thirteenMonthsAgoNumber' AND '$lastMonthLastDay'
                                        AND (LENGTH(NUM_SER) = 10 AND NUM_SER REGEXP '^[0-9]+$')");
        //維修保固內
        $warrantyCountIn = DB::select("SELECT COUNT(*) AS result_count
                                        FROM mes_rma_analysis
                                        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                                        AND NUM_SER BETWEEN '$thirteenMonthsAgoNumber' AND '$lastMonthLastDay'");

        //維修其它
        $warrantyCountOther = $warrantyCount[0]->result_count - $warrantyCountOut[0]->result_count - $warrantyCountIn[0]->result_count;

        if ($warrantyCountIn[0]->result_count == 0) {
            $warrantyPercent[0] = ['warrantyCountIn', 0, 0];
            $warrantyPercent[1] = ['warrantyCountOut', 0, 0];
            $warrantyPercent[2] = ['warrantyCountOther', 0, 0];
            $warrantyPercent[3] = ['warrantyCount', 0, 0];
            $warrantyPercent[4] = ['warrantyTest', 0, 0];
            $warrantyPercent[5] = ['warrantyQty', 0, 0];
            $warrantyPercent[6] = ['warrantyDuty', 0, 0];
        } else {
            //計算全部維修的百分比      
            $warrantyPercent[0] = ['warrantyCountIn', $warrantyCountIn[0]->result_count, number_format(($warrantyCountIn[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            $warrantyPercent[1] = ['warrantyCountOut', $warrantyCountOut[0]->result_count, number_format(($warrantyCountOut[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            $warrantyPercent[2] = ['warrantyCountOther', $warrantyCountOther, number_format(($warrantyCountOther / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            $warrantyPercent[3] = ['warrantyCount', $warrantyCount[0]->result_count, number_format(($warrantyCount[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            //測試正常數量
            $warrantyTest = DB::select("SELECT COUNT(*) AS result_count
                        FROM mes_rma_analysis
                        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                        AND ps1_2 = '測試正常'");

            //維修數量
            $warrantyQty = DB::select("SELECT COUNT(*) AS result_count
                        FROM mes_rma_analysis
                        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                        AND (ps1_2 != '測試正常' OR ps1_2 IS NULL)");

            $warrantyPercent[4] = ['warrantyTest', $warrantyTest[0]->result_count, number_format(($warrantyTest[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            $warrantyPercent[5] = ['warrantyQty', $warrantyQty[0]->result_count, number_format(($warrantyQty[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
            $warrantyDuty = DB::select("SELECT COUNT(*) AS result_count
                                    FROM (
                                        SELECT *
                                        FROM mes_rma_analysis
                                        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                                        AND NUM_SER BETWEEN '$thirteenMonthsAgoNumber' AND '$lastMonthLastDay'
                                        AND (PS1_3 = '廠商' OR PS1_3 = '本廠')
                                        GROUP BY NUM_ONCA
                                    ) AS grouped_data");

            $warrantyPercent[6] = ['warrantyDuty', $warrantyDuty[0]->result_count, number_format(($warrantyDuty[0]->result_count / $warrantyCount[0]->result_count) * 100, 1) . '%'];
        }
        //RAM維修 上個月明細
        $mesRMAErrorList = DB::select("SELECT *  FROM mes_rma_analysis 
        WHERE NUM_MTRM BETWEEN '$warrantyDateS' 
        AND '$warrantyDateE' 
        AND (NUM_SER BETWEEN '$thirteenMonthsAgoNumber'
        AND '$lastMonthLastDay' )
        AND (PS1_3 = '廠商' OR PS1_3 = '本廠')         
        GROUP BY `NUM_ONCA`
        ORDER BY COD_ITEM ASC, MTRM_PS ASC");

        //AA重工
        $lastMonth = date('ym', strtotime('first day of last month'));        
        $mesRemakeAAList = DB::select("SELECT * FROM mac_query WHERE  NUM_PS LIKE 'AA$lastMonth%' GROUP BY CLDS_COD_ITEM");
        
        
        //平均維修
        $warrantyAVG = DB::select("SELECT AVG(HUR_REQ) AS average_hur_req
                                    FROM mes_rma_analysis
                                    WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE'
                                    AND HUR_REQ > 0");

        $averageHurReq =  round($warrantyAVG[0]->average_hur_req, 2);
        $borrowItem = DashboardModel::getBorrowItem();
        //庫存排行榜 90天出貨
        $unsalableProducts = DashboardModel::getUnsalableProducts();
        for ($i = 0; $i < count($unsalableProducts); $i++) {
            $modal =  $unsalableProducts[$i]->COD_ITEM;
            $today = date("Ymd");
            $Days90 = date("Ymd", strtotime("-90 days"));
            $getStockShipment = DashboardModel::getStockShipment($modal, $today, $Days90);
            $unsalableProducts[$i]->sellQty = $getStockShipment[0]->sellQty;
        }


        //工單生產狀況
        $productionData = $this->productionStatus();
        for ($i = 0; $i <  count($productionData['productionStatus']); $i++) {
            $num_ps = $productionData['productionStatus'][$i]->NUM_PS;
            $productionDataAVG = DB::select("SELECT AVG(time_diff) AS average_time
            FROM (
                SELECT TIMESTAMPDIFF(SECOND, work_startTime, work_endTime) AS time_diff
                FROM runcard
                WHERE num_ps = '$num_ps' AND SEQ_NO = '001'
            ) AS time_diffs;");
            $minutes = floor($productionDataAVG[0]->average_time / 60);
            $remainingSeconds = $productionDataAVG[0]->average_time % 60;
            // 格式化输出
            $formattedTime = sprintf("%d分%d秒", $minutes, $remainingSeconds);
            $productionData['productionStatus'][$i]->average_time = $formattedTime;
        }
        //不良統計表(當月)
        $description = $this->description();
        $lang = app()->getLocale();
        $page = 'dashboardLeader';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('dashboardLeader', compact('langArray', 'sidebarLang', 'productionData', 'seasonDates', 'borrowItem', 'unsalableProducts', 'shipmentMon', 'shipmentThisMon', 'shipmentRanking', 'maintenData', 'warrantyPercent', 'description','mesRMAErrorList','mesRemakeAAList'));
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
        $mainten = DB::select("SELECT * ,work_no, COUNT(*) as count FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate%' GROUP BY work_no");
        if (count($mainten) === 0) {
            $data = DB::select("SELECT * FROM runcard_ng_rate ORDER BY ng_id DESC LIMIT 1");
            $maintenDate = substr($data[0]->num_comr, 0, -4);
            $mainten = DB::select("SELECT * ,work_no, COUNT(*) as count FROM runcard_ng_rate WHERE num_comr LIKE '$maintenDate%' GROUP BY work_no");
        }
        $maintenPie = $this->maintenPie($maintenDate);
        $maintenDate = substr($maintenDate, 2, 2) . '-' . substr($maintenDate, 4, 2) . '-' . substr($maintenDate, 6, 2);

        return ['mainten' => $mainten, 'maintenDate' => $maintenDate, 'maintenPie' => $maintenPie];
    }
    public function maintenPie($maintenDate)
    {
        $maintenPie = DB::select("SELECT
                                        r.STS_COMR,
                                        d.description AS comr_desc,
                                        COUNT(*) AS COUNT
                                    FROM
                                        runcard_ng_rate AS r
                                    LEFT JOIN
                                        defective AS d
                                    ON
                                        r.sts_comr = d.item_no
                                    WHERE
                                        r.num_comr LIKE '$maintenDate%'
                                    GROUP BY
                                        r.sts_comr, d.description
                                    ");
        $totalCount = 0;
        foreach ($maintenPie as $item) {
            $totalCount += $item->COUNT;
        }
        foreach ($maintenPie as &$item) {
            $item->per = ($item->COUNT / $totalCount) * 100;
        }
        unset($item);
        return $maintenPie;
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
        $today = 'MR' . date('ym');
        $previousDate = 'MR' . date('ymd', strtotime('-30 days', strtotime(date('ymd')))) . '0001';
        $description = DB::select("SELECT
                                        a.sts_comr,
                                        c.description AS comr_desc,
                                        COUNT(c.description) AS count_comr
                                    FROM
                                        runcard_ng_rate AS a
                                        LEFT JOIN defective AS c ON a.sts_comr = c.item_no
                                    WHERE
                                    a.num_comr LIKE '$today%'                                    
                                    GROUP BY
                                    comr_desc
                                    ORDER BY
                                    count_comr DESC
                                    LIMIT 10
                                    ");


        $total = 0;
        foreach ($description as $key => $value) {
            $total +=  $value->count_comr;
        }
        foreach ($description as $key => $value) {
            $value->total = number_format(($value->count_comr / $total) * 100, 1) . '%';
        }

        return $description;
    }

    function getPreviousSeasonDates()
    {
        $currentMonth = date('n'); // 获取当前月份，不带前导零
        $year= date('Y')  ;
        if ($currentMonth <= 3) {
            
            $startSeasonDate =  $year -1 .'1001';
            $endSeasonDate =   $year -1 .'1231';
          
        }elseif($currentMonth >= 4 && $currentMonth <= 6 ){
            $startSeasonDate =  $year.'0101';
            $endSeasonDate =  $year.'0331';
           
        }elseif($currentMonth >= 7 && $currentMonth <= 9 ){
            $startSeasonDate =  $year.'0401';
            $endSeasonDate =  $year.'0631';
           
        }else{
            $startSeasonDate =  $year.'0701';
            $endSeasonDate =  $year.'0930';
        }
        return [
            'start' => $startSeasonDate,
            'end' => $endSeasonDate,
        ];

        
    }

    

}
