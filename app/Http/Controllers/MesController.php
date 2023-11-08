<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MesModelList;
use App\Services\LangService;
use Illuminate\Support\Facades\Auth;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ConditionalRules;

class MesController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }

    public function mesRepairProducts(Request $request)
    {

        return view('mesRepairProducts');
    }

    public function mesModelList(Request $request)
    {
        //獲取資料
        $MesModelList = MesModelList::getModelListData();
        if ($MesModelList) {

            $lang = app()->getLocale();
            $page = 'mesModelList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesModelList', compact('MesModelList', 'langArray', 'sidebarLang'));
        }
    }

    public function mesUploadList(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'mesUploadList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesUploadList', compact('langArray', 'sidebarLang'));
    }

    public function mesUploadListAjax(Request $request)
    {
        $searchtype = $request->input('searchtype');
        $search = $request->input('search');
        $rans = date('Y-m-d', strtotime($request->input('rangS')));
        $rane = date('Y-m-d', strtotime($request->input('rangE') + 1));
        if ($searchtype == 'upload_date') {
            // $mesUploadListAjax = DB::table('fw_index')
            //     ->whereBetween('upload_date', [DB::raw("'$rans'"), DB::raw("'$rane'")])
            //     ->orderBy('fw_id', 'asc')
            //     ->get();

            $mesUploadListAjax = DB::select("SELECT * FROM `fw_index` WHERE upload_date BETWEEN '0000-00-00 00:00:00' AND '2099-10-31 23:59:59'");
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


        $lang = app()->getLocale();
        $page = 'editFirmware';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $editFirmware = DB::table('fw_index')
            ->where('fw_id', $request->id)
            ->get();

        return view('editFirmware', compact('langArray', 'sidebarLang', 'editFirmware'));
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
            $lang = app()->getLocale();
            $page = 'inventoryItemList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('inventoryItemList', compact('MesItemList', 'langArray', 'sidebarLang'));
        }
    }

    public function inventoryItemPartList(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'inventoryItemList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);



        $MesItemPartList = DB::select("SELECT * FROM `mes_lcst_parts` GROUP BY COD_LOC");
        if ($request->query('target')) {
            $model = $request->query('target');
            $modelData = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE COD_ITEM LIKE '$model%'");
            $bomItem = DB::select("SELECT * FROM mes_mbom WHERE COD_ITEMS = '$model'");



            return view('inventoryItemPartList', compact('modelData', 'MesItemPartList', 'bomItem', 'langArray', 'sidebarLang'));
        } else {
            $modelData = '';
            $bomItem = '';



            return view('inventoryItemPartList', compact('modelData', 'MesItemPartList', 'bomItem', 'langArray', 'sidebarLang'));
        }
    }



    public function inventoryItemPartListAjax(Request $request)
    {

        $model = $request->input('search');
        $bomItem = DB::select("SELECT * FROM mes_mbom WHERE COD_ITEMS = '$model'");
        if (count($bomItem) > 0) {
            $countBomItem = count($bomItem);
        } else {

            $countBomItem = 0;
        }


        //獲取資料

        $depository = $request->input('depository');
        if ($depository === 'all') {
            $value = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE COD_ITEM LIKE '$model%';");
        } else {
            $value = DB::select("SELECT * FROM `mes_lcst_parts` LEFT JOIN mes_mesitempartlist_uploadimg on mes_mesitempartlist_uploadimg.model = mes_lcst_parts.COD_ITEM WHERE COD_LOC = '$depository' AND  COD_ITEM LIKE '$model%' ");
        }
        $result = [
            'bomItem' => $bomItem,
            'value' => $value,
            'countBomItem' => $countBomItem
        ];

        return response()->json($result);
    }


    public function mesKickoffList(Request $request)
    {
        //獲取資料
        $MesKickoffList = MesModelList::getKickoffListData();
        if ($MesKickoffList) {
            $lang = app()->getLocale();
            $page = 'mesKickoffList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesKickoffList', compact('MesKickoffList', 'langArray', 'sidebarLang'));
        }
    }

    public function mesCutsQuery(Request $request)
    {
        //獲取資料
        $MesCutsQuery = MesModelList::getCutsQueryData();
        if ($MesCutsQuery) {
            $lang = app()->getLocale();
            $page = 'mesCutsQuery';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesCutsQuery', compact('MesCutsQuery', 'langArray', 'sidebarLang'));
        }
    }

    public function dateFunction()
    {
        $date = [];
        $year = date('Y');
        $month = date('m');
        for ($i = 0; $i < 12; $i++) {
            // 當前年份和月份
            $currentYear = $year;
            $currentMonth = $month;

            // 使用减去 $i
            if ($currentMonth - $i <= 0) {
                $currentYear -= 1;
                $currentMonth = 12 - ($i - $currentMonth);
            } else {
                $currentMonth -= $i;
            }
            // 格式化月份为两位数
            $formattedMonth = sprintf("%02d", $currentMonth);
            // 将年份和月份存入数组中
            $date[] = (object)['year' => $currentYear, 'month' => $formattedMonth];
        }

        $lastyear = [];
        for ($i = 2019; $i <= $date[0]->year; $i++) {
            $lastyear[] = (object) ['lastyear' => $i];
        }

        return [$date, $lastyear];
    }

    public function mesMonProductionList(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'mesMonProductionList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        list($date, $lastyear) = $this->dateFunction();
        if ($date && $lastyear) {
            return view('mesMonProductionList', compact('langArray', 'sidebarLang', 'date', 'lastyear'));
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
        $lang = app()->getLocale();
        $page = 'mesProductionResumeList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesProductionResumeList', compact('langArray', 'sidebarLang'));
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
            $lang = app()->getLocale();
            $page = 'mesHistoryProductionQuantity';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesHistoryProductionQuantity', compact('MesHistoryProductionQuantity', 'langArray', 'sidebarLang'));
        }
    }

    public function mesMfrList(Request $request)
    {

        $MesMfrList = MesModelList::getMesMfrList();

        if ($MesMfrList) {
            $lang = app()->getLocale();
            $page = 'mesMfrList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesMfrList', compact('MesMfrList', 'langArray', 'sidebarLang'));
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

            $lang = app()->getLocale();
            $page = 'mesRunCardList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesRunCardList', compact('date', 'lastyear', 'langArray', 'sidebarLang'));
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
            $lang = app()->getLocale();
            $page = 'mesRuncardListNotin';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesRuncardListNotin', compact('date', 'lastyear', 'langArray', 'sidebarLang'));
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
        $lang = app()->getLocale();
        $page = 'mesDefectiveList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesDefectiveList', compact('langArray', 'sidebarLang'));
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
        $lang = app()->getLocale();
        $page = 'mesDefectiveRate';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesDefectiveRate', compact('date', 'lastyear', 'langArray', 'sidebarLang'));
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
        $lang = app()->getLocale();
        $page = 'mesRepairNGList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesRepairNGList', compact('date', 'lastyear', 'langArray', 'sidebarLang'));
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
        $lang = app()->getLocale();
        $page = 'mesBuyDelay';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesBuyDelay', compact('langArray', 'sidebarLang'));
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
            $value = DB::SELECT("SELECT * FROM mes_purchase_overdue WHERE DAT_POR > 0");
            return response()->json($value);
        } else {
            $value = DB::SELECT("SELECT * FROM mes_purchase_overdue WHERE DAT_POR = 0");

            return response()->json($value);
        }
    }

    public function mesECNList(Request $request)
    {
        //獲取資料
        $MesECNList = MesModelList::getMesECNList();
        if ($MesECNList) {
            $lang = app()->getLocale();
            $page = 'mesECNList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('mesECNList', compact('MesECNList', 'langArray', 'sidebarLang'));
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
            $lang = app()->getLocale();
            $page = 'mesECNList';
            $langArray = $this->langService->getLang($lang, $page);
            $page = 'sidebar';
            $sidebarLang = $this->langService->getLang($lang, $page);
            return view('editECRN', compact('editECRN', 'langArray', 'sidebarLang'));
        }
    }



    public function RMAList(Request $request)
    {

 
        $lang = app()->getLocale();
        $page = 'RMAList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('RMAList', compact('langArray', 'sidebarLang'));
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
        $lastMonthFirstDay = date('ym01', strtotime('first day of last month'));
        $lastMonthLastDay = date('ymd', strtotime('last day of last month'));
        $warrantyDateS = 'FB' . $lastMonthFirstDay . '0000';
        $warrantyDateE = 'FB' . $lastMonthLastDay . '9999';
        $targetDateTime = \DateTime::createFromFormat('ymd', $lastMonthLastDay);
        $firstDayOfPrevious13Months = $targetDateTime->sub(new \DateInterval('P13M'))->modify('first day of this month');
        $resultDate = $firstDayOfPrevious13Months->format('ymd');

        $mesRMAErrorItemAjax = DB::select("SELECT *  FROM mes_rma_analysis 
        WHERE NUM_MTRM BETWEEN '$warrantyDateS' 
        AND '$warrantyDateE' 
        AND NUM_SER BETWEEN $resultDate
        AND $lastMonthLastDay 
        AND (PS1_3 = '廠商' OR PS1_3 = '本廠') 
        GROUP BY `NUM_ONCA`");
        return response()->json($mesRMAErrorItemAjax);
    }
    public function RMA30dsAjax(Request $request)
    {

        $lastMonthFirstDay = date('ym01', strtotime('first day of last month'));
        $lastMonthLastDay = date('ymd', strtotime('last day of last month'));
        $warrantyDateS = 'FB' . $lastMonthFirstDay . '0000';
        $warrantyDateE = 'FB' . $lastMonthLastDay . '9999';
        // $warrantyDateS = 'FB' . date('ymd', strtotime('-30 days', strtotime(date('ymd')))) . '0000';
        $mesRMA30dsAjax = DB::select("SELECT *
        FROM mes_rma_analysis
        WHERE NUM_MTRM BETWEEN '$warrantyDateS' AND '$warrantyDateE '");
        return response()->json($mesRMA30dsAjax);
    }
    public function RMAAnalysis(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'RMAAnalysis';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('RMAAnalysis', compact('langArray', 'sidebarLang'));
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
        $timeInterval = $request->input('timeInterval');

        $currentDate = date('Ymd');
        $thirtyDaysAgo = date('Ymd', strtotime('-30 days'));
        $ninetyDaysAgo = date('Ymd', strtotime('-90 days'));

        $dateFilter = "";

        if ($timeInterval == 'ninety') {
            $dateFilter = "AND (DAT_ONCA BETWEEN $ninetyDaysAgo AND $currentDate)";
        } elseif ($timeInterval == 'thirty') {
            $dateFilter = "AND (DAT_ONCA BETWEEN $thirtyDaysAgo AND $currentDate)";
        }

        $mesRMAbadPartAjax = DB::select("SELECT MTRM_PS AS part, COUNT(MTRM_PS) AS count
        FROM mes_rma_analysis
        WHERE $searchtype LIKE '%$search%' $dateFilter
        GROUP BY MTRM_PS
        ORDER BY count DESC
        LIMIT 10;");

        $mesRMAbadReasonAjax = DB::select("SELECT PS1_1 AS reason, COUNT(PS1_1) AS count
        FROM mes_rma_analysis
        WHERE $searchtype LIKE '%$search%' $dateFilter
        GROUP BY PS1_1
        ORDER BY count DESC
        LIMIT 10;");

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

        $lang = app()->getLocale();
        $page = 'mesShipmentList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        return view('mesShipmentList', compact('langArray', 'sidebarLang'));
    }
    public function mesBOM(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'mesBOM';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        return view('mesBOM', compact('langArray', 'sidebarLang'));
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



    public function mesRmaEdit(Request $request)
    {


        $lang = app()->getLocale();
        $page = 'mesRmaEdit';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $codeA = DB::select(" SELECT * FROM mes_faultcode WHERE faultcode LIKE  'A%'");
        $faultcodeA = [];
        foreach ($codeA as $row) {
            $faultcodeA[] = $row->faultcode;
        }
        $codeAMap = [];
        foreach ($codeA as $code) {
            $codeAMap[$code->faultcode] = $code->fault;
        }

        $codeB = DB::select(" SELECT * FROM mes_faultcode WHERE faultcode LIKE  'B%'");
        $faultcodeB = [];
        foreach ($codeB as $row) {
            $faultcodeB[] = $row->faultcode;
        }
        $codeBMap = [];
        foreach ($codeB as $code) {
            $codeBMap[$code->faultcode] = $code->fault;
        }
        return view('mesRmaEdit', compact('langArray', 'sidebarLang', 'faultcodeA', 'codeAMap', 'faultcodeB', 'codeBMap'));
    }
    public function mesRmaEditAjax(Request $request)
    {
        $search = $request->input('serchCon');

        if (strpos($search, ":") !== false) {
            $data = DB::select(" SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE PS2  = '$search'
            limit 1");
        } else {
            $data = DB::select(" SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE SEQ_MITEM = '$search'
            limit 1");
        }
        if (count($data) == 0) {
            $data = DB::select(" SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE SEQ_ITEM = '$search'
            limit 1");
        }
        //    LEFT JOIN mes_mbom AS mes_mbom on mes_mbom.COD_ITEM = pops.COD_ITEM 


        $data[0]->employee_id = Auth::user()->employee_id;
        return response()->json($data);
    }

    public function mesRmaGetNumAjax(Request $request)
    {
        $numTitle = $request->input('numTitle');
        $numData = DB::select(" SELECT * FROM mes_rma_edit
            WHERE NUM LIKE '$numTitle%'
            ORDER BY NUM desc
            limit 1");
        if (count($numData) > 0) {
            $num = $numData[0]->NUM;
            $numberPart = preg_replace('/[^0-9]/', '', $num);
            $newNumber = $numberPart + 1;
            $newCode = preg_replace('/[0-9]+/', $newNumber, $num);
        } else {
            $today = date('Ymd');
            $newCode = $numTitle . $today . '001';
        }

        return response()->json($newCode);
    }
}
