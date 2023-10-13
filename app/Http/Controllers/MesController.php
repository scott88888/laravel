<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MesModelList;



use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MesController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    public function mesRepairProducts(Request $request)
    {

        return view('mesRepairProducts');
    }

    public function mesModelList(Request $request)
    {
        //獲取資料
        $MesModelList = MesModelList::getModelListData();
        if ($MesModelList) {
            return view('mesModelList', ['MesModelList' => $MesModelList]);
        }
    }

    public function mesUploadList(Request $request)
    {
        return view('mesUploadList');
    }

    public function mesUploadListAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $rans = date('Y-m-d', strtotime($request->input('rangS')));
        $rane = date('Y-m-d', strtotime($request->input('rangE') + 1));
        if ($searchtype == 'upload_date') {
            $mesUploadListAjax = DB::table('fw_index')
                ->whereBetween('upload_date', [DB::raw("'$rans'"), DB::raw("'$rane'")])
                ->orderBy('fw_id', 'asc')
                ->get();
        } else {
            $mesUploadListAjax = DB::table('fw_index')
                ->where($searchtype, 'like', '%' . $search . '%')
                ->orderBy('fw_id', 'asc')
                ->get();
        }
        return response()->json($mesUploadListAjax);
    }


    public function editFirmware(Request $request)
    {

        $editFirmware = DB::table('fw_index')
            ->where('fw_id', $request->id)
            ->get();


        return view('editFirmware', ['editFirmware' => $editFirmware]);
    }

    public function delFirmwareAjax(Request $request)
    {
        $data = DB::table('fw_index')
            ->where('fw_id', $request->input('fw_id'))
            ->get();
        $directory = $data[0]->model_no . '_' . $data[0]->model_name . '_' . $data[0]->version . '_' . $data[0]->model_customer . '_' . $data[0]->customer;
        $insertDelFile = MesModelList::insertDelFile($directory, $data);
        //建立bat檔案 
        if ($insertDelFile) {
            $this->createBAT();
        }
        //刪除資料
        $delfw_id = DB::table('fw_index')->where('fw_id', $request->input('fw_id'))->delete();
        if ($delfw_id) {
            return response()->json(['message' => '删除成功']);
        } else {
            return response()->json(status: 400);
        }
    }

    function createBAT()
    {
        $delurl = DB::table('mes_del_file')
            ->whereDate('del_time', today())
            ->get();
        $batchContent = '@echo off' . PHP_EOL;

        foreach ($delurl as $key => $value) {
            $batchContent .= 'rd /s /q "Z:/www/MES/lilin/upload/' . $value->file_url . '"' . PHP_EOL;
        }
        $batchContent .= 'echo. > "' . public_path('file.bat') . '"';
        $batchFilePath = public_path('file.bat');
        file_put_contents($batchFilePath, $batchContent);
    }

    public function inventoryItemList(Request $request)
    {
        //獲取資料
        $MesItemList = MesModelList::getItemListData();
        if ($MesItemList) {
            return view('inventoryItemList', ['MesItemList' => $MesItemList]);
        }
    }

    public function inventoryItemPartList(Request $request)
    {
     
        $MesItemPartList = DB::select("SELECT * FROM `mes_lcst_parts` GROUP BY COD_LOC");
        if ($request->query('target')) {
            $model = $request->query('target');
            $modelData = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE  COD_ITEM LIKE '$model%'");
            $bomItem = DB::select("SELECT * FROM mes_mbom WHERE COD_ITEMS = '$model'"); 
            return view('inventoryItemPartList', compact('modelData', 'MesItemPartList','bomItem'));
            
        }else {
            $modelData = '';
            $bomItem = '';          
            return view('inventoryItemPartList', compact('modelData', 'MesItemPartList','bomItem'));
        }
 
    }



    public function inventoryItemPartListAjax(Request $request)
    {   
        $model = $request->input('search');
        $bomItem = DB::select("SELECT * FROM mes_mbom WHERE COD_ITEMS = '$model'");
        if ($bomItem) {
            $countBomItem = count($bomItem);
        }
        //獲取資料
        
        $depository = $request->input('depository');
        if (!$depository) {
            $value = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE  COD_ITEM LIKE '$model%';");
        } else {
            $value = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE COD_LOC = '$depository' AND  COD_ITEM LIKE '$model%' ");
        }
        $result = [
            'bomItem' => $bomItem,
            'value' => $value,
            'countBomItem'=> $countBomItem
        ];
        
        return response()->json($result);
    }


    public function mesKickoffList(Request $request)
    {
        //獲取資料
        $MesKickoffList = MesModelList::getKickoffListData();
        if ($MesKickoffList) {

            return view('mesKickoffList', ['MesKickoffList' => $MesKickoffList]);
        }
    }

    public function mesCutsQuery(Request $request)
    {
        //獲取資料
        $MesCutsQuery = MesModelList::getCutsQueryData();
        if ($MesCutsQuery) {

            return view('mesCutsQuery', ['MesCutsQuery' => $MesCutsQuery]);
        }
    }

    public function dateFunction()
    {
        //獲取月份
        $date = [];
        $lastyear = [];
        $year = date('Y');
        $month = date('m');
        for ($i = 0; $i < 12; $i++) {
            // 當前月份減去 $i 個月
            $timestamp = strtotime("-{$i} month");
            // 取得年份和月份
            $year = date('Y', $timestamp);
            $month = date('m', $timestamp);
            // 將年份和月份存入陣列中
            $date[] = (object)['year' => $year, 'month' => $month];
        }
        // 生成從 2019 到最後一個年份的資料，並加入到 $date 陣列中
        for ($i = 2019; $i <= $date[11]->year; $i++) {
            $lastyear[] = (object) ['lastyear' => $i];
        }
        return [$date, $lastyear];
    }

    public function mesMonProductionList(Request $request)
    {
        list($date, $lastyear) = $this->dateFunction();
        if ($date && $lastyear) {
            return view('mesMonProductionList', compact('date', 'lastyear'));
        }
    }

    public function mesMonProductionListAjax(Request $request)
    {
        //獲取資料

        $launchDate = $request->input('launch_date');
        $deliveryDate = $request->input('delivery_date');

        if ($launchDate) {
            $type = 'launchDate';
            $mesMonProductionListAjax = MesModelList::getMonProductionListAjax($type, $launchDate);
            return response()->json($mesMonProductionListAjax);
        }
        if ($deliveryDate) {
            $type = 'deliveryDate';
            $mesMonProductionListAjax = MesModelList::getMonProductionListAjax($type, $deliveryDate);
            return response()->json($mesMonProductionListAjax);
        }
    }
    public function mesProductionResumeList(Request $request)
    {
        return view('mesProductionResumeList');
    }

    public function mesProductionResumeListAjax(Request $request)
    {

        if ($request->input('search') && $request->input('searchtype')) {
            $search = $request->input('search');
            $searchtype = $request->input('searchtype');
            $mesProductionResumeListAjax = MesModelList::getProductionResumeListAjax($search, $searchtype);
            return response()->json($mesProductionResumeListAjax);
        };
        return response()->json(status: 400);
    }
    public function mesProductionResumeListDayAjax(Request $request)
    {

        if ($request->input('date') && $request->input('searchtype')) {
            $date = $request->input('date');
            $searchtype = $request->input('searchtype');
            $mesProductionResumeListDayAjax = MesModelList::getProductionResumeListDayAjax($date, $searchtype);
            return response()->json($mesProductionResumeListDayAjax);
        };
        return response()->json(status: 400);
    }


    public function mesHistoryProductionQuantity(Request $request)
    {

        $MesHistoryProductionQuantity = MesModelList::getHistoryProductionQuantity();
        if ($MesHistoryProductionQuantity) {
            return view('mesHistoryProductionQuantity', ['MesHistoryProductionQuantity' => $MesHistoryProductionQuantity]);
        }
    }

    public function mesMfrList(Request $request)
    {

        $MesMfrList = MesModelList::getMesMfrList();

        if ($MesMfrList) {
            return view('mesMfrList', ['MesMfrList' => $MesMfrList]);
        }
    }

    public function mesRunCardList(Request $request)
    {
        list($date, $lastyear) = $this->dateFunction();

        // 當前月份的第一天和最後一天
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');

        // 獲取資料
        $MesRunCardList = MesModelList::getRunCardList($first_day, $last_day);

        if ($date && $lastyear) {
            return view('mesRunCardList', compact('date', 'lastyear'));
        }
    }


    public function mesRunCardListAjax(Request $request)
    {
        if ($request->input('launchDate') != NULL) {
            $launchdate = $request->input('launchDate');

            if (strlen($launchdate) == 4) {
                $search = $launchdate;
                $searchtype = 'thisyear';
                $last_day = date('Y-m-t', strtotime($launchdate));
                $mesRunCardListAjax = MesModelList::getRunCardListAjax($search, $searchtype);
            }
            if (strlen($launchdate) == 7) {
                $first_day = date('Y-m-01', strtotime($launchdate));
                $last_day = date('Y-m-t', strtotime($launchdate));
                $mesRunCardListAjax = MesModelList::getRunCardList($first_day, $last_day);
            }
            return response()->json($mesRunCardListAjax);
        }


        if ($request->input('search') && $request->input('searchtype') && $request->input('launchDate') == NULL) {
            $search = $request->input('search');
            $searchtype = $request->input('searchtype');
            $mesRunCardListAjax = MesModelList::getRunCardListAjax($search, $searchtype);
            return response()->json($mesRunCardListAjax);
        };
        return response()->json(status: 400);
    }

    public function mesRuncardListNotin(Request $request)
    {
        list($date, $lastyear) = $this->dateFunction();
        if ($date && $lastyear) {
            return view('mesRuncardListNotin', compact('date', 'lastyear'));
        }
    }

    public function mesRuncardListNotinAjax(Request $request)
    {
        //獲取資料

        $launchDate = $request->input('launch_date');
        $deliveryDate = $request->input('delivery_date');

        if ($launchDate) {
            $type = 'launchDate';
            $mesRuncardListNotinAjax = MesModelList::getRuncardListNotinAjax($type, $launchDate);
            return response()->json($mesRuncardListNotinAjax);
        }
        if ($deliveryDate) {
            $type = 'deliveryDate';
            $mesRuncardListNotinAjax = MesModelList::getRuncardListNotinAjax($type, $deliveryDate);
            return response()->json($mesRuncardListNotinAjax);
        }
        return response()->json(status: 400);
    }


    public function mesDefectiveList()
    {
        return view('mesDefectiveList');
    }

    public function mesDefectiveListAjax(Request $request)
    {
        if ($request->input('search') && $request->input('searchtype')) {
            $search = $request->input('search');
            $searchtype = $request->input('searchtype');
            $mesDefectiveListAjax = MesModelList::getDefectiveListAjax($searchtype, $search);
            return response()->json($mesDefectiveListAjax);
        };
        return response()->json(status: 400);
    }

    public function mesDefectiveRate()
    {
        list($date, $lastyear) = $this->dateFunction();
        return view('mesDefectiveRate', compact('date', 'lastyear'));
    }

    public function mesDefectiveRateAjax(Request $request)
    {
        $launchDate = $request->input('launchDate');
        if ($launchDate) {
            if (strlen($launchDate) == 6) {
                $launchDate = substr($launchDate, -4);
            } else {
                $launchDate = substr($launchDate, -2);
            }
            $mesDefectiveRateAjax = MesModelList::getDefectiveRateAjax($launchDate);
            return response()->json($mesDefectiveRateAjax);
        }
    }

    //
    public function mesRepairNGList()
    {
        list($date, $lastyear) = $this->dateFunction();
        return view('mesRepairNGList', compact('date', 'lastyear'));
    }

    public function mesRepairNGListAjax(Request $request)
    {
        //此功能需重寫，PART_NO欄位，在202206以前 有加密過跟沒加密過
        //目前將資料固定為202206，需確認欄位功能後重寫搜索條件
        $value = DB::select("SELECT `PART_NO`, count(*) as count_sum FROM `runcard_ng` where `DAT_COMR` LIKE '202206%' AND `PART_NO` <> '' group by `PART_NO` order by count_sum desc;");
        return response()->json($value);
    }

    public function mesBuyDelay()
    {

        return view('mesBuyDelay');
    }

    public function mesBuyDelayAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $daytime = $request->input('date');
        $today = date('Ymd');
        if ($daytime == '20999999') {
            $today = '20009999';
        }

        if ($searchtype == 'MaterialDeliveryDate') {
            $value = DB::table('mes_purchase_overdue')
                ->select('*')                
                ->whereBetween('DAT_POR', [$today, $daytime])
                ->where('DAT_POR', '>', 0)
                ->orderBy('DAT_BUY', 'desc')
                ->get();
            return response()->json($value);
        } else {
            $value = DB::table('mes_purchase_overdue')
                ->whereNull('DAT_POR')
                ->orWhere('DAT_POR', '')
                ->whereBetween('DAT_REQ', [$today, $daytime])
                ->orderBy('DAT_BUY', 'desc')
                ->get();
            return response()->json($value);
        }

        // if ($searchtype) {
        //     $mesBuyDelayAjax = MesModelList::getBuyDelayAjax($searchtype);
        //     return response()->json($mesBuyDelayAjax);
        // } else {
        //     return response()->json('nodata');
        // }
    }

    public function mesECNList(Request $request)
    {
        //獲取資料
        $MesECNList = MesModelList::getMesECNList();
        if ($MesECNList) {
            return view('mesECNList', ['MesECNList' => $MesECNList]);
        }
    }
    public function ECRECNList(Request $request)
    {
        //獲取資料
        $MesECNList = MesModelList::getMesECNList();
        if ($MesECNList) {
            return view('ECRECNList', ['MesECNList' => $MesECNList]);
        }
    }
    public function editECRN(Request $request)
    {
        //獲取資料
        $editECRN = DB::table('mes_ecrecn')
            ->where('id', $request->id)
            ->get();
        if ($editECRN) {
            return view('editECRN', ['editECRN' => $editECRN]);
        }
    }



    public function RMAList(Request $request)
    {
        //獲取資料
        return view('RMAList');
    }
    public function RMAListAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $mesRMAListAjax = MesModelList::getRMAAnalysisAjax($searchtype, $search);
        return response()->json($mesRMAListAjax);
    }

    public function RMAErrorItemAjax(Request $request)
    {
        $warrantyDateE = 'FB' . date('ymd') . '9999';
        $warrantyDateS = 'FB' . date('ymd', strtotime('-30 days', strtotime(date('ymd')))) . '0000';
        $todayNumber = date('ym') . '999999';
        $thirteenMonthsAgoNumber = date('ym', strtotime('-13 months')) . '000000';
        $mesRMAErrorItemAjax = DB::select("SELECT *  FROM mes_rma_analysis 
        WHERE NUM_MTRM BETWEEN '$warrantyDateS' 
        AND '$warrantyDateE' 
        AND NUM_SER BETWEEN $thirteenMonthsAgoNumber 
        AND $todayNumber 
        AND (PS1_3 = '廠商' OR PS1_3 = '本廠') 
        GROUP BY `NUM_ONCA`");
        return response()->json($mesRMAErrorItemAjax);
    }
    public function RMA30dsAjax(Request $request)
    {
        $warrantyDateE = 'FB' . date('ymd') . '9999';
        $warrantyDateS = 'FB' . date('ymd', strtotime('-30 days', strtotime(date('ymd')))) . '0000';
        $mesRMA30dsAjax = DB::select("SELECT *
        FROM mes_rma_analysis
        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE '");
        return response()->json($mesRMA30dsAjax);
    }
    public function RMAAnalysis(Request $request)
    {
        return view('RMAAnalysis');
    }
    public function RMAAnalysisAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $mesRMAAnalysisAjax = MesModelList::getRMAAnalysisAjax($searchtype, $search);
        return response()->json($mesRMAAnalysisAjax);
    }
    public function RMAbadPartAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $mesRMAbadPartAjax = DB::table('mes_rma_analysis')
            ->select('MTRM_PS AS part', DB::raw('COUNT(MTRM_PS) AS count'))
            ->where($searchtype, 'like', '%' . $search . '%')

            ->groupBy('MTRM_PS')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $mesRMAbadReasonAjax = DB::table('mes_rma_analysis')
            ->select('PS1_1 AS reason', DB::raw('COUNT(PS1_1) AS count'))
            ->where($searchtype, 'like', '%' . $search . '%')
            ->groupBy('PS1_1')
            ->orderByDesc('count')
            ->take(10)
            ->get();
        $response = [
            'badPart' => $mesRMAbadPartAjax,
            'badReason' => $mesRMAbadReasonAjax
        ];

        return response()->json($response);
    }

    public function mesShipmentListAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $rans = $request->input('rangS');
        $rane = $request->input('rangE');
        $mesShipmentListAjax = MesModelList::getShipmentListAjax($searchtype, $search, $rans, $rane);
        return response()->json($mesShipmentListAjax);
    }

    public function mesShipmentList(Request $request)
    {
        return view('mesShipmentList');
    }
    public function mesBOM(Request $request)
    {
        return view('mesBOM');
    }
    public function mesBOMItemAjax(Request $request)
    {
        $search = $request->input('search');

        $mesBOMItem = DB::select("SELECT * FROM mes_item_list WHERE COD_ITEM LIKE '$search%'");
        $today = date("Ymd");
        $Days90 = date("Ymd", strtotime("-90 days"));
        for ($i = 0; $i < count($mesBOMItem); $i++) {
            $COD_ITEM = $mesBOMItem[$i]->COD_ITEM;
            $itemQty = DB::select("SELECT SUM(QTY_DEL) as QTY_DEL FROM mes_deld_shipment WHERE COD_ITEM = '$COD_ITEM' AND (DAT_DEL BETWEEN '$Days90' AND '$today')");
            $QTY_STK = DB::select("SELECT SUM(QTY_STK) AS QTY_STK FROM mes_lcst_item WHERE COD_ITEM = '$COD_ITEM'");
            $mesBOMItem[$i]->QTY_DEL = $itemQty[0]->QTY_DEL;
            $mesBOMItem[$i]->QTY_STK = $QTY_STK[0]->QTY_STK;
        }
        return response()->json($mesBOMItem);
    }
    public function mesBOMSelectAjax(Request $request)
    {
        $search = $request->input('modalValue');

        // $search = 'Z6R6452X3';
        $mesBOMItem = DB::select("SELECT * FROM mes_mbom WHERE COD_ITEM = '$search' ORDER BY COD_ITEM ASC, COD_ITEMS ASC ");

        for ($i = 0; $i < count($mesBOMItem); $i++) {
            $COD_ITEMS = $mesBOMItem[$i]->COD_ITEMS;
            $results = DB::select("SELECT 
            (SELECT SUM(QTY_STK) FROM mes_lcst_parts WHERE COD_ITEM = '$COD_ITEMS') AS QTY_parts,
            (SELECT NAM_ITEM FROM mes_lcst_parts WHERE COD_ITEM = '$COD_ITEMS' LIMIT 1) AS NAM_ITEM,
            (SELECT SUM(QTY_STK) FROM mes_lcst_item WHERE COD_ITEM = '$COD_ITEMS') AS QTY_item");

            $SUN_QTY = DB::select("SELECT * , SUM(UN_QTY) AS SUN_QTY
                                    FROM mes_purchase_overdue
                                    WHERE COD_ITEM = '$COD_ITEMS'");

            if (!empty($results)) {
                $qty = $results[0]->QTY_parts + $results[0]->QTY_item;
                $mesBOMItem[$i]->qty = $qty;
                $NAM_ITEM = $results[0]->NAM_ITEM;
                $mesBOMItem[$i]->NAM_ITEM = $NAM_ITEM;
                $mesBOMItem[$i]->SUN_QTY =  $SUN_QTY[0]->SUN_QTY;
                $mesBOMItem[$i]->DAT_REQ =  $SUN_QTY[0]->DAT_REQ;
                $mesBOMItem[$i]->inventory =  $qty + $SUN_QTY[0]->SUN_QTY; 
            } else {
                $mesBOMItem[$i]->qty = '0';
                $mesBOMItem[$i]->NAM_ITEM = '';
                $mesBOMItem[$i]->SUN_QTY =  '';
                $mesBOMItem[$i]->DAT_REQ = '';
                $mesBOMItem[$i]->inventory = '';
            }
        }
        return response()->json($mesBOMItem);
    }
}
