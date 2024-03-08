<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MesModelList;
use App\Services\LangService;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            $value = DB::SELECT("SELECT * FROM mes_purchase_overdue WHERE DAT_POR > 0  AND (DAT_POR BETWEEN '$today' AND '$daytime')");
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
        AND (NUM_SER BETWEEN '$resultDate'
        AND '$lastMonthLastDay' )
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

        $model = '';
        if ($request->model) {
            $model = $request->model;
        }

        return view('RMAAnalysis', compact('langArray', 'sidebarLang', 'model'));
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
    public function mesRmaSear(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'mesECNList';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('mesRmaSear', compact('langArray', 'sidebarLang'));
    }


    public function mesRmasearAjax(Request $request)
    {

        $numTitle = $request->input('numTitle');
        $repairNum = $request->input('repairNum');
        $noticeDateS = $request->input('noticeDateS');
        $noticeDateE = $request->input('noticeDateE');
        $formatted_dateS = str_replace("-", "", $noticeDateS);
        $formatted_dateE = str_replace("-", "", $noticeDateE);


        if ($repairNum) {
            $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE NUM like '$numTitle$repairNum%'");
        } else {
            $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE noticeDate BETWEEN '$formatted_dateS' AND '$formatted_dateE' ");
        }

        return response()->json($mesRmaSearData);
    }
    public function mesRmasear30daysAjax(Request $request)
    {
        $todayDate = date('Ymd');
        $currentDate = new \DateTime($todayDate);
        $currentDate->modify('last month');
        $previousMonthDate = $currentDate->format('Ymd');

        $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE noticeDate BETWEEN '$previousMonthDate' AND '$todayDate' ");
        return response()->json($mesRmaSearData);
    }
    public function mesRmasearConditionAjax(Request $request)
    {

        $condition1 = $request->input('condition1');
        $condition2 = $request->input('condition2');
        $finDate = $request->input('finDate');
       
        if ($condition1 == 1) {
            $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE repairType = '$condition2'");
        }
        if ($condition1 == 2) {           
            $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE formStat = '$condition2'");
        }
        if ($condition1 == 3) {
            $mesRmaSearData = DB::select("SELECT *  FROM mes_rma_edit WHERE completedDate like '$finDate%'");
        }


        return response()->json($mesRmaSearData);
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

        // $ramData = DB::select(" SELECT * FROM mes_rma_edit WHERE NUM =  'FA231213001' limit 1");
        // $NUM = $ramData[0]->NUM;
        // $noticeDate = $ramData[0]->noticeDate;
        // $customerNumber = $ramData[0]->customerNumber;
        // $repairType = $ramData[0]->repairType;
        // $customerAttn = $ramData[0]->customerAttn;
        // $customerTel = $ramData[0]->customerTel;
        // $productNum = $ramData[0]->productNum;
        // $repairType = $ramData[0]->repairType;
        // switch ($repairType) {
        //     case '維修':
        //         $repairType = '1';
        //         break;
        //     case '借品':
        //         $repairType = '2';
        //         break;
        //     case '借品專用':
        //         $repairType = '3';
        //         break;
        //     case '換':
        //         $repairType = '4';
        //         break;
        //     case '退':
        //         $repairType = '5';
        //         break;
        //     default:
        //         $repairType = '1';
        //         break;
        // }

        // $userID = $ramData[0]->userID;
        // $customerAdd = $ramData[0]->customerAdd;
        // $date = date("YmdHis").'0000';
        // $date2 = date("YmdHis");
        // $sql = "INSERT INTO onca ('NUM_ONCA',
        // 'DAT_ONCA',
        // 'COD_CUST',
        // 'NUM_DPT',
        // 'NAM_ATTN',
        // 'TEL_ATTN',
        // 'COD_ITEM',
        // 'NUM_SER',
        // 'COD_MAKER',
        // 'COD_WAR',
        // 'ONCA_LV',
        // 'ONCA_IR',
        // 'CNT_ONCA',
        // 'DSC_ONCA',
        // 'DAT_REQ',
        // 'DAT_SCHE',
        // 'NUM_MTRM',
        // 'EMP_MT',
        // 'DAT_MTRM',
        // 'DAT_OK',
        // 'MNY_CTR',
        // 'DSC_ANS',
        // 'DAT_TCKET',
        // 'NUM_TCKET',
        // 'TAX_TYPE',
        // 'NUM_PS',
        // 'NUM_ORD',
        // 'ADD_DPT',
        // 'NUM_ARMM',
        // 'DAT_ARMM',
        // 'EMP_SCHE',
        // 'DAT_PLAN',
        // 'STS_ONCA',
        // 'COD_DOLA',
        // 'VAL_RATE',
        // 'DPT_ORD',
        // 'EMP_ORD',
        // 'FAX_ATTN',
        // 'EMAIL',
        // 'DOC_CONM',
        // 'NUM_CNTL',
        // 'HUR_MEN',
        // 'HUR_MGET',
        // 'HUR_RPT',
        // 'DAT_CQC',
        // 'STS_CQC',
        // 'DSC_CQC',
        // 'DPT_NOW',
        // 'EMP_CQC',
        // 'BIL_CUST',
        // 'HUR_RECV',
        // 'DM_KEYIN',
        // 'EMP_MAIL',
        // 'DM_MAIL',
        // 'EMP_CANCEL',
        // 'DM_CANCEL',
        // 'DSC_CANCEL',
        // 'DM_XFER',
        // 'EMP_XFER',
        // 'HUR_ACT',
        // 'DAT_ACT',
        // 'EMP_ACT',
        // 'DTM_SCHE',
        // 'EMP_COMP',
        // 'DTM_OK',
        // 'COD_AR',
        // 'DSC_AR',
        // 'HUR_CSAR',
        // 'COD_CSAR',
        // 'DSC_CSAR',
        // 'AMT_INVM',
        // 'AMT_TAXV',
        // 'AMT_TOTV',
        // 'RCV_ONCA',
        // 'QTY_ONCA',
        // 'NUM_ONCAM',
        // 'LIN_ONCAM',
        // 'ROT_ORD',
        // 'DAT_BEGS',
        // 'TIM_BEGS',
        // 'EMP_KEYIN',
        // 'ONCA2QS',
        // 'CLS_TRN',
        // 'NUM_TRN',
        // 'DAT_TRN',
        // 'SER_PCS',
        // 'SRV_ONCA',
        // 'REMARK',
        // 'CLS_BREAK',
        // 'ONCA_IRC',
        // 'PS1',
        // 'PS2',
        // 'PS3',
        // 'COD_PCST',
        // 'NAM_PCST',
        // 'COD_CUSTS',
        // 'NAM_ATTNS',
        // 'ADR_CUSTS',
        // 'NUM_DPTS',
        // 'DPT_CTL',
        // 'EMP_QFAX',
        // 'DTM_QFAX',
        // 'DAT_CQCP',
        // 'LEV_CQC',
        // 'TELL_CHARG',
        // 'LEV_ANY',
        // 'DSC_CUSTS',
        // 'FBAK2ANS',
        // 'NUM_DOCM',
        // 'LIN_DOCM',
        // 'BONCA_RST1',
        // 'BONCA_RST2',
        // 'BONCA_RST3',
        // 'STS_CFBAK',
        // 'EMP_MAIL1',
        // 'DM_MAIL1',
        // 'NUM_CASE',
        // 'EMP_CLDS',
        // 'DAT_CLDS',
        // 'TIM_CLDS',
        // 'COD_ANS',
        // 'DTM_FAXQT',
        // 'EMP_FAXQT',
        // 'CNT_FAXQT',
        // 'DISC_ONCA',
        // 'HUR_MENP',
        // 'TIM_REQ',
        // 'DTM_STOPB',
        // 'DTM_STOPE',
        // 'LIN_TRN',
        // 'LEV_DSRV',
        // 'UID_OK',
        // 'TIM_OK',
        // 'NAM_INVD',
        // 'AMT_INVD',
        // 'DAT_HAPN',
        // 'TIM_HAPN',
        // 'DPT_AR',
        // 'COD_PAYM',
        // 'TEL_ATTNS',
        // 'POS_AREA',
        // 'FAX_ATTNS',
        // 'REGYN_INVD',
        // 'CLS_CSTC',
        // 'NUM_CSTC1',
        // 'NUM_DONATE',
        // 'DTM_2LINE',
        // 'UID_2LINE',
        // 'EMP_UPD',
        // 'DTM_UPD',
        // 'DAT_SUGB',
        // 'TIM_SUGB',
        // 'DAT_SUGE',
        // 'TIM_SUGE',
        // 'DTM_SXFER',
        // 'UID_SXFER') 
        // VALUES (
        // '$NUM',
        // '$noticeDate',
        // '$customerNumber',
        // '0000',
        // '$customerAttn',
        // '$customerTel',
        // '$productNum',
        // NULL,
        // NULL,
        // NULL,
        // '1',
        // '$repairType',
        // '0',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '$userID',
        // NULL,
        // NULL,
        // '0',
        // NULL,
        // NULL,
        // NULL,
        // '1',
        // 'RA231201001',
        // NULL,
        // '$customerAdd',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '00',
        // 'NTD',
        // '1',
        // '0810',
        // 'G02',
        // '',
        // NULL,
        // NULL,
        // NULL,
        // '0',
        // '0',
        // '0',
        // NULL,
        // NULL,
        // NULL,
        // '0810',
        // NULL,
        // NULL,
        // '0',
        // '$date',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '0',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '0',
        // NULL,
        // NULL,
        // '0',
        // '0',
        // '0',
        // '004',
        // '1',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '$userID',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '01',
        // NULL,
        // NULL,
        // '1',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '$customerNumber',
        // '$customerAttn',
        // '$customerAdd',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '0',
        // '0',
        // '0',
        // NULL,
        // NULL,
        // NULL,

        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '0',
        // NULL,
        // NULL,
        // NULL,
        // '24',
        // NULL,
        // NULL,
        // NULL,
        // 'Y',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // '$userID',
        // '$date2',
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL,
        // NULL);";

        // echo $sql;
        // exit;

        if ($request->num) {

            $encryptedDataWithIV = $request->num;
            $iv = openssl_random_pseudo_bytes(16);
            // var_dump($encryptedDataWithIV);
            list($encryptedData, $iv) = explode('::', base64_decode($encryptedDataWithIV), 2);
            $key = 'meritlilin0123456789012345678901';
            $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $key, 0, $iv);
            $ramData = DB::select(" SELECT * FROM mes_rma_edit WHERE NUM =  '$decryptedData' limit 1");

            // $ramData = DB::select(" SELECT * FROM mes_rma_edit WHERE NUM =  '$request->num' limit 1");
            $pagetype = "update";
        } else {
            $nullData = [
                'ID' => null,
                'NUM' => null,
                'repairType' => null,
                'customerNumber' => null,
                'customerName' => null,
                'serchCon' => null,
                'svgImage' => null,
                'customerAttn' => null,
                'customerTel' => null,
                'customerAdd' => null,
                'productNum' => null,
                'productName' => null,
                'noticeDate' => null,
                'faultSituationCode' => null,
                'faultSituation' => null,
                'faultCauseCode' => null,
                'faultCause' => null,
                'faultPart' => null,
                'faultLocation' => null,
                'responsibility' => null,
                'SN' => null,
                'newSN' => null,
                'QADate' => null,
                'completedDate' => null,
                'userID' => null,
                'userName' => null,
                'toll' => null,
                'workingHours' => null,
                'newPackaging' => null,
                'wire' => null,
                'wipePackaging' => null,
                'rectifier' => null,
                'lens' => null,
                'lensText' => null,
                'HDD' => null,
                'HDDText' => null,
                'other' => null,
                'otherText' => null,
                'maintenanceStaffID' => null,
                'maintenanceStaff' => null,
                'money' => null,
                
                'records' => null,
                'records2' => null,
                'formStat' => null,
                'remark' => null,
                'SEQ_MITEM' => null

            ];
            $pagetype = "create";
            // 将包含所有列都为null的数组赋值给$ramData
            $ramData = [(object)$nullData];
        }

        if ($ramData[0]->maintenanceStaffID == null) {
            $ramData[0]->maintenanceStaffID = Auth::user()->employee_id;
            $ramData[0]->maintenanceStaff = Auth::user()->name;
        }
        


        $lang = app()->getLocale();
        $page = 'mesRmaEdit';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $codeA = DB::select(" SELECT * FROM mes_faultcode WHERE faultcode LIKE  'A%'");
        $codeB = DB::select(" SELECT * FROM mes_faultcode WHERE faultcode LIKE  'B%'");

        return view('mesRmaEdit', compact('langArray', 'sidebarLang', 'codeA', 'codeB', 'ramData', 'pagetype'));
    }
    public function mesRmaEditAjax(Request $request)
    {
        $search = $request->input('serchCon');

        if (strpos($search, ":") !== false) {
            $data = DB::select("SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE PS2  = '$search'
            limit 1");
        } else {
            $data = DB::select("SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE SEQ_MITEM = '$search'
            limit 1");
        }
        if (empty($data)) {
            $data = DB::select(" SELECT * FROM mac_query 
            LEFT JOIN pops AS pops on pops.NUM_PS = mac_query.NUM_PS 
            LEFT JOIN CUST AS CUST on CUST.COD_CUST = pops.COD_CUST 
            WHERE SEQ_ITEM = '$search'
            limit 1");
        }

        //    LEFT JOIN mes_mbom AS mes_mbom on mes_mbom.COD_ITEM = pops.COD_ITEM 
        $COD_ITEM = $data[0]->COD_ITEM;
        $modal = DB::select("SELECT * FROM `mes_lcst_parts` WHERE COD_ITEM = '$COD_ITEM' limit 1");
        $data[0]->NAM_ITEM = $modal[0]->NAM_ITEM;
        $data[0]->employee_id = Auth::user()->employee_id;
        $data[0]->userName = Auth::user()->name;

        return response()->json($data);
    }

    public function mesRmaEditReceiptCreateAjax(Request $request)
    {

        $numTitle = $request->input('numTitle');
        $newCodeNum = $this->mesRmaGetNumAjax($numTitle);


        $num = $numTitle . $newCodeNum[0]->newNumber;
        $key = 'meritlilin0123456789012345678901';
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedData = openssl_encrypt($num, 'AES-256-CBC', $key, 0, $iv);
        $encryptedDataWithIV = base64_encode($encryptedData . '::' . $iv);
        $newNumber = $newCodeNum[0]->newNumber;
        $qrCodeUrl = QrCode::format('svg')->generate('https://lilinmes.meritlilin.com.tw:778/mesRmaEdit?num=' . urlencode($encryptedDataWithIV));
        $qrCode = base64_encode($qrCodeUrl);
        $this->mesRmaGetNumAjax($request);
        $data = DB::table('mes_rma_qrcode')->insertGetId([
            'ID' => '',
            'NUM' => $num,
            'num256' => urlencode($encryptedDataWithIV),
            'qrcode' => $qrCode,
        ]);

        return response()->json(['newNumber' => $newNumber, 'qrCode' => $qrCode]);
    }

    public function mesRmaEditReceiptSaveAjax(Request $request)
    {
        $numTitle = $request->input('numTitle');
        $repairNum = $request->input('repairNum');
        $num = $numTitle . $repairNum;
        $selectedValue = $request->input('selectedValue');
        $serchCon = $request->input('serchCon');
        $qrcode = DB::select("SELECT * FROM `mes_rma_qrcode` WHERE NUM = '$num' limit 1");
        $svgImage = 'data:image/svg+xml;base64,' . $qrcode[0]->qrcode;
        $num256 = $qrcode[0]->num256;
        $customerNumber = $request->input('customerNumber');
        $customerName = $request->input('customerName');
        $customerAttn = $request->input('customerAttn');
        $customerTel = $request->input('customerTel');
        $customerAdd = $request->input('customerAdd');
        $productNum = $request->input('productNum');
        $productName = $request->input('productName');
        $userID = $request->input('userID');
        $userName = $request->input('userName');
        $noticeDate = $request->input('noticeDate');
        $newPackaging = $request->input('newPackaging');
        $wire = $request->input('wire');
        $wipePackaging = $request->input('wipePackaging');
        $rectifier = $request->input('rectifier');
        $lens = $request->input('lens');
        $HDD = $request->input('HDD');
        $other = $request->input('other');
        $lensText = $request->input('lensText');
        $HDDText = $request->input('HDDText');
        $otherText = $request->input('otherText');
        $formStat = $request->input('formStat');
        $remark = $request->input('remark');
        $SEQ_MITEM = $request->input('SEQ_MITEM');
        $data = DB::table('mes_rma_edit')->insertGetId([
            'ID' => '',
            'NUM' => $num,
            'repairType' => $selectedValue,
            'serchCon' => $serchCon,
            'svgImage' => $svgImage,
            'customerNumber' => $customerNumber,
            'customerName' => $customerName,
            'customerAttn' => $customerAttn,
            'customerTel' => $customerTel,
            'customerAdd' => $customerAdd,
            'productNum' => $productNum,
            'productName' => $productName,
            'userID' => $userID,
            'userName' => $userName,
            'noticeDate' => str_replace("-", "", $noticeDate),
            'newPackaging' => $newPackaging,
            'wire' => $wire,
            'wipePackaging' => $wipePackaging,
            'rectifier' => $rectifier,
            'lens' => $lens,
            'lensText' => $lensText,
            'HDD' => $HDD,
            'HDDText' => $HDDText,
            'other' => $other,
            'otherText' => $otherText,
            'num256' => $num256,
            'formStat' => $formStat,
            'remark' => $remark,
            'SN' => $SEQ_MITEM,
            'newSN' => $SEQ_MITEM
        ]);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json($data);
        }
    }


    public function mesRmaEditReceiptUpdateAjax(Request $request)
    {
        $idNum = $request->input('idNum');
        $numTitle = $request->input('numTitle');
        $repairNum = $request->input('repairNum');
        $num = $numTitle . $repairNum;
        $selectedValue = $request->input('selectedValue');
        $serchCon = $request->input('serchCon');
        $customerNumber = $request->input('customerNumber');
        $customerName = $request->input('customerName');
        $customerAttn = $request->input('customerAttn');
        $customerTel = $request->input('customerTel');
        $customerAdd = $request->input('customerAdd');
        $productNum = $request->input('productNum');
        $productName = $request->input('productName');
        $userID = $request->input('userID');
        $userName = $request->input('userName');
        $noticeDate = $request->input('noticeDate');
        $newPackaging = $request->input('newPackaging');
        $wire = $request->input('wire');
        $wipePackaging = $request->input('wipePackaging');
        $rectifier = $request->input('rectifier');
        $lens = $request->input('lens');
        $HDD = $request->input('HDD');
        $other = $request->input('other');
        $lensText = $request->input('lensText');
        $HDDText = $request->input('HDDText');
        $otherText = $request->input('otherText');
        $formStat = $request->input('formStat');
        $remark = $request->input('remark');
        if ($noticeDate) {
            $noticeDate = preg_replace('/-/', '', $noticeDate);
        }
        // 假设您有一个名为 'idNum' 的条件用于确定要更新的记录

        $data = [
            'NUM' => $num,
            'repairType' => $selectedValue,
            'serchCon' => $serchCon,
            'customerNumber' => $customerNumber,
            'customerName' => $customerName,
            'customerAttn' => $customerAttn,
            'customerTel' => $customerTel,
            'customerAdd' => $customerAdd,
            'productNum' => $productNum,
            'productName' => $productName,
            'userID' => $userID,
            'userName' => $userName,
            'noticeDate' => $noticeDate,
            'newPackaging' => $newPackaging,
            'wire' => $wire,
            'wipePackaging' => $wipePackaging,
            'rectifier' => $rectifier,
            'lens' => $lens,
            'lensText' => $lensText,
            'HDD' => $HDD,
            'HDDText' => $HDDText,
            'other' => $other,
            'otherText' => $otherText,
            'formStat' => $formStat,
            'remark' => $remark
        ];

        // 使用 update 方法来更新数据，并获取更新是否成功的结果
        $updateResult = DB::table('mes_rma_edit')
            ->where('ID', $idNum)
            ->update($data);

        if ($updateResult) {
            return response()->json($data);
        } else {
            return response()->json('error');
        }
    }
    public function mesMaintenanceUpdateAjax(Request $request)
    {
        $idNum = $request->input('idNum');
        $faultSituationCode = $request->input('faultSituationCode');
        $faultCauseCode = $request->input('faultCauseCode');
        $faultPart = $request->input('faultPart');
        $faultLocation = $request->input('faultLocation');
        $responsibility = $request->input('responsibility');
        $SN = $request->input('SN');
        $newSN = $request->input('newSN');
        $QADate = $request->input('QADate');
        $completedDate = $request->input('completedDate');
        $maintenanceStaffID = $request->input('maintenanceStaffID');
        $maintenanceStaff = $request->input('maintenanceStaff');
        $money = $request->input('money');
        $toll = $request->input('toll');
        $workingHours = $request->input('workingHours');
        $records = $request->input('records');
        $records2 = $request->input('records2');
        $formStat = $request->input('formStat');
        // 假设您有一个名为 'idNum' 的条件用于确定要更新的记录

        $data = [
            'faultSituationCode' => $faultSituationCode,
            'faultCauseCode' => $faultCauseCode,
            'faultPart' => $faultPart,
            'faultLocation' => $faultLocation,
            'responsibility' => $responsibility,
            'SN' => $SN,
            'newSN' => $newSN,
            'QADate' => $QADate,
            'completedDate' => $completedDate,
            'maintenanceStaffID' => $maintenanceStaffID,
            'maintenanceStaff' => $maintenanceStaff,
            "money" =>$money,
            'toll' => $toll,
            'workingHours' => $workingHours,
            'records' => $records,
            'records2' => $records2,
            'formStat' => $formStat
        ];

        // 使用 update 方法来更新数据，并获取更新是否成功的结果
        $updateResult = DB::table('mes_rma_edit')
            ->where('ID', $idNum)
            ->update($data);

        if ($updateResult) {
            return response()->json($faultSituationCode);
        } else {
            return response()->json('error');
        }
    }
    public function mesCustomerSearchAjax(Request $request)
    {
        $customerNumber = $request->input('customerNumber');
        $customerList = DB::select("SELECT cdpt.* ,cust.NAM_CUST FROM `cdpt` LEFT JOIN cust ON cust.COD_CUST = cdpt.COD_CUST WHERE cdpt.COD_CUST = '$customerNumber'");

        if ($customerList) {
            return response()->json($customerList);
        } else {
            return response()->json('error');
        }
    }

    public function mesRmaeEditSave(Request $request)
    {
        $numTitle = $request->input('numTitle');
        $repairNum = $request->input('repairNum');
        $num = $numTitle . $repairNum;
        $selectedValue = $request->input('selectedValue');
        $customerNumber = $request->input('customerNumber');
        $customerName = $request->input('customerName');
        $productNum = $request->input('productNum');
        $productName = $request->input('productName');
        $noticeDate = $request->input('noticeDate');
        $faultSituationCodes = $request->input('faultSituationCodes');
        $faultSituation = explode('-', $faultSituationCodes);
        $faultCauseCodes = $request->input('faultCauseCodes');
        $faultCause = explode('-', $faultCauseCodes);
        $faultPart = $request->input('faultPart');
        $faultLocation = $request->input('faultLocation');
        $responsibility = $request->input('responsibility');
        $SN = $request->input('SN');
        $newSN = $request->input('newSN');
        $QADate = $request->input('QADate');
        $completedDate = $request->input('completedDate');
        $employeeID = $request->input('employeeID');
        $employeeName = $request->input('employeeName');
        $toll = $request->input('toll');
        $workingHours = $request->input('workingHours');
        $newPackaging = $request->input('newPackaging');
        $wire = $request->input('wire');
        $wipePackaging = $request->input('wipePackaging');
        $rectifier = $request->input('rectifier');
        $lens = $request->input('lens');
        $lensText = $request->input('lensText');
        $HDD = $request->input('HDD');
        $HDDText = $request->input('HDDText');
        $other = $request->input('other');
        $otherText = $request->input('otherText');


        $data = DB::table('mes_rma_edit')->insert([
            'ID' => '',
            'NUM' => $num,
            'repairType' => $selectedValue,
            'customerNumber' => $customerNumber,
            'customerName' => $customerName,
            'productNum' => $productNum,
            'productName' => $productName,
            'noticeDate' => $noticeDate,
            'faultSituationCode' => $faultSituation[0],
            'faultSituation' => $faultSituation[1],
            'faultCauseCode' => $faultCause[0],
            'faultCause' => $faultCause[1],
            'faultPart' => $faultPart,
            'faultLocation' => $faultLocation,
            'responsibility' => $responsibility,
            'SN' => $SN,
            'newSN' => $newSN,
            'QADate' => $QADate,
            'completedDate' => $completedDate,
            'userID' => $employeeID,
            'userName' => $employeeName,
            'toll' => $toll,
            'workingHours' => $workingHours,
            'newPackaging' => $newPackaging,
            'wire' => $wire,
            'wipePackaging' => $wipePackaging,
            'rectifier' => $rectifier,
            'lens' => $lens,
            'lensText' => $lensText,
            'HDD' => $HDD,
            'HDDText' => $HDDText,
            'other' => $other,
            'otherText' => $otherText
        ]);
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json($data);
        }
    }


    public function mesRmaGetNumAjax($numTitle)
    {

        $today = date('ymd');
        $numData = DB::select(" SELECT * FROM mes_rma_edit
            WHERE NUM LIKE '$numTitle$today%'
            ORDER BY NUM desc
            limit 1");
        if (count($numData) > 0) {
            $num = $numData[0]->NUM;
            $numberPart = preg_replace('/[^0-9]/', '', $num);
            $newNumber = $numberPart + 1;
            $newCode = preg_replace('/[0-9]+/', $newNumber, $num);
        } else {
            $newCode = $numTitle . $today . '0001';
            $newNumber = $today . '0001';
        }

        $newCodeNum[] = (object)['newCode' => $newCode, 'newNumber' => $newNumber];
        return $newCodeNum;
    }

    public function mesMSDS()
    {
        $lang = app()->getLocale();
        $page = 'mesMSDS';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        $casCode = DB::select(" SELECT * FROM mes_msds_cas");

        return view('mesMSDS', compact('langArray', 'sidebarLang', 'casCode'));
    }
    public function mesMSDSAjax(Request $request)
    {
        $searchType = $request->input('searchType');
        $searchName = $request->input('searchName');

        if ($searchType == 'COD_FACT') {
            $data = DB::select("SELECT * FROM mes_fitm
            LEFT JOIN mes_fact ON mes_fitm.COD_FACT = mes_fact.COD_FACT
            WHERE mes_fitm.COD_FACT LIKE '$searchName%'
            ORDER BY mes_fitm.COD_FACT desc; ");
        } else {
            $data = DB::select("SELECT * FROM mes_fitm
            LEFT JOIN mes_fact ON mes_fitm.COD_FACT = mes_fact.COD_FACT
            WHERE mes_fitm.COD_ITEM LIKE '$searchName%'
            ORDER BY mes_fitm.COD_FACT desc; ");
        }



        if ($data) {
            return response()->json($data);
        }
    }
    public function mesCasCodeSearchAjax(Request $request)
    {

        $casCode = $request->input('casCode');
        $data = DB::select(" SELECT * FROM mes_msds_cas WHERE CASNo = '$casCode' ");

        if ($data) {
            return response()->json($data);
        }
    }

    public function mesCasInsertAjax(Request $request)
    {

        $partName = $request->input('partName');
        $partNumber = $request->input('partNumber');
        $casCode = $request->input('casCode');
        $CAS_NoE = $request->input('CAS_NoE');
        $CAS_NoC = $request->input('CAS_NoC');
        $content = $request->input('content');
        $COD_FACT = $request->input('COD_FACT_part');

        $insertGetId = DB::table('mes_msds_list')->insertGetId([
            'id' => '',
            'partName' => $partName,
            'partNumber' => $partNumber,
            'casCode' => $casCode,
            'CAS_NoE' => $CAS_NoE,
            'CAS_NoC' => $CAS_NoC,
            'content' => $content,
            'COD_FACT' => $COD_FACT
        ]);
        return response()->json($insertGetId);
    }

    public function mesSelectMSDSAjax(Request $request)
    {

        $modalValue = $request->input('modalValue');
        $COD_FACT = $request->input('COD_FACT');

        $data = DB::select("SELECT mes_msds_list.* ,mes_msds_part.COD_ITEM,mes_msds_part.partWeight, (mes_msds_part.partWeight * mes_msds_list.content / 100 ) AS weight FROM mes_msds_list
        LEFT JOIN mes_msds_part ON mes_msds_list.COD_FACT = mes_msds_part.COD_FACT
        WHERE mes_msds_list.COD_FACT = '$COD_FACT' AND mes_msds_list.partNumber = '$modalValue' AND mes_msds_part.COD_ITEM ='$modalValue' ");

        return response()->json($data);
    }
    public function mesDelMSDSAjax(Request $request)
    {
        $result = $request->input('result');
        // 使用 array_filter() 過濾出數字
        $numericValues = array_filter($result, 'is_numeric');
        $firstNumber = reset($numericValues); // 取得第一個符合條件的元素
        if (count($numericValues) == 1) {
            $sql = DB::delete("DELETE FROM mes_msds_list WHERE id = '$firstNumber'");
        } else {
            $sql = DB::delete('DELETE FROM mes_msds_list WHERE id IN (' . implode(',', $result) . ')');
        }

        $COD_FACT = $request->input('COD_FACT');
        $partNumber = $request->input('partNumber');

        if ($sql > 0) {
            $data = DB::select("SELECT mes_msds_list.* ,mes_msds_part.COD_ITEM,mes_msds_part.partWeight, (mes_msds_part.partWeight * mes_msds_list.content / 100 ) AS weight FROM mes_msds_list
            LEFT JOIN mes_msds_part ON mes_msds_list.COD_FACT = mes_msds_part.COD_FACT
            WHERE mes_msds_list.COD_FACT = '$COD_FACT' AND mes_msds_list.partNumber = '$partNumber' AND mes_msds_part.COD_ITEM ='$partNumber' ");
            return response()->json($data);
        } else {
            return response()->json('刪除失敗');
        }
    }
    public function mesMSDSupdateWeightAjax(Request $request)
    {
        $COD_FACT = $request->input('COD_FACT');
        $partNumber = $request->input('partNumber');
        $partWeight = $request->input('partWeight');
        $selectPart = DB::select(" SELECT * FROM `mes_msds_part` WHERE COD_FACT = '$COD_FACT' AND COD_ITEM = '$partNumber'");
        if ($selectPart) {
            DB::delete(" DELETE FROM `mes_msds_part` WHERE COD_FACT = '$COD_FACT' AND COD_ITEM = '$partNumber'");
        }
        DB::insert("INSERT INTO `mes_msds_part` (`id`, `COD_FACT`, `COD_ITEM`, `partWeight`) VALUES ('', '$COD_FACT', '$partNumber', '$partWeight')");


        $data = DB::select("SELECT mes_msds_list.* ,mes_msds_part.COD_ITEM,mes_msds_part.partWeight, (mes_msds_part.partWeight * mes_msds_list.content / 100 ) AS weight FROM mes_msds_list
        LEFT JOIN mes_msds_part ON mes_msds_list.COD_FACT = mes_msds_part.COD_FACT
        WHERE mes_msds_list.COD_FACT = '$COD_FACT' AND mes_msds_list.partNumber = '$partNumber' AND mes_msds_part.COD_ITEM ='$partNumber' ");
        return response()->json($data);
    }

    public function mesMSDSCopyListAjax(Request $request)
    {
        $searchType = $request->input('searchType');
        $searchName = $request->input('searchName');
        $sourceItem = $request->input('sourceItem');


        if ($searchType) {
            $data = DB::select("SELECT * FROM mes_fitm
            LEFT JOIN mes_fact ON mes_fitm.COD_FACT = mes_fact.COD_FACT
            WHERE mes_fitm.COD_FACT = '$searchName' AND mes_fitm.COD_ITEM  <> '$sourceItem'
            ORDER BY mes_fitm.COD_FACT desc; ");
        }


        if ($data) {
            return response()->json($data);
        }
    }

    public function mesMSDSCopyAjax(Request $request)
    {
        $searchType = $request->input('searchType');
        $searchName = $request->input('searchName');
        $sourceItem = $request->input('sourceItem');
        $selectedCheckboxes = $request->input('selectedCheckboxes');



        if (count($selectedCheckboxes) > 0) {

            for ($i = 0; $i < count($selectedCheckboxes); $i++) {
                $itemID = $selectedCheckboxes[$i];
                $data = DB::select("SELECT * FROM mes_fitm WHERE id = '$itemID'");
                $itemName = $data[0]->COD_ITEM;
                DB::delete("DELETE FROM mes_msds_part WHERE COD_ITEM = '$itemName' AND COD_FACT = '$searchName' ");
                DB::insert("INSERT INTO mes_msds_part (COD_FACT, COD_ITEM, partWeight)
            SELECT COD_FACT, '$itemName' AS COD_ITEM , partWeight
            FROM mes_msds_part
            WHERE COD_ITEM = '$sourceItem' AND COD_FACT = '$searchName';");

                DB::delete("DELETE FROM mes_msds_list WHERE partNumber = '$itemName' AND COD_FACT = '$searchName' ");
                DB::insert("INSERT INTO mes_msds_list (partName, partNumber, casCode, CAS_NoE,CAS_NoC,content,COD_FACT)
             SELECT partName, '$itemName' AS partNumber, casCode, CAS_NoE,CAS_NoC,content,COD_FACT
             FROM mes_msds_list
             WHERE partNumber = '$sourceItem' AND COD_FACT = '$searchName';");
            }
        }
        return response()->json($data);
    }

    public function mesEditMSDSAjax(Request $request)
    {
        $id = $request->input('editCOSid');


        $partName = $request->input('partName');
        $partNumber = $request->input('partNumber');
        $casCode = $request->input('casCode');
        $CAS_NoE = $request->input('CAS_NoE');
        $CAS_NoC = $request->input('CAS_NoC');
        $content = $request->input('content');
        $COD_FACT_part =  $request->input('COD_FACT_part');
        $insert = DB::insert("UPDATE `mes_msds_list` SET `id`=$id, `partName`='$partName', `partNumber`='$partNumber', `casCode`='$casCode', `CAS_NoE`='$CAS_NoE', `CAS_NoC`='$CAS_NoC', `content`='$content', `COD_FACT`='$COD_FACT_part' WHERE `id`=$id;
");

        if ($insert) {
            $data = DB::select("SELECT mes_msds_list.* ,mes_msds_part.COD_ITEM,mes_msds_part.partWeight, (mes_msds_part.partWeight * mes_msds_list.content / 100 ) AS weight FROM mes_msds_list
                LEFT JOIN mes_msds_part ON mes_msds_list.COD_FACT = mes_msds_part.COD_FACT
                WHERE mes_msds_list.COD_FACT = '$COD_FACT_part' AND mes_msds_list.partNumber = '$partNumber' AND mes_msds_part.COD_ITEM ='$partNumber' ");
        };


        return response()->json($data);
    }
}
