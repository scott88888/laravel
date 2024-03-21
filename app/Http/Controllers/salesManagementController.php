<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Http\Request;
use App\Services\LangService;

class salesManagementController extends BaseController
{
    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }

    public function shippingManagement()
    {

        $lang = app()->getLocale();
        $page = 'shippingManagement';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $shippingManagement = DB::select("SELECT * FROM `mes_lcst_parts` WHERE  COD_ITEM LIKE '72%' GROUP BY COD_ITEM");
        $modal = DB::select("SELECT COD_ITEM FROM mes_item_list GROUP BY COD_ITEM");
        return view('shippingManagement', compact('shippingManagement', 'modal', 'langArray', 'sidebarLang'));
    }

    public function palletPython($resultString, $searchtype, $pallet)
    {
        $pythonScriptPath = 'C:\xampp\htdocs\3DBinPacking\pallet.py';
        $arg = '-t ' . $searchtype . ' -c ' . $pallet . $resultString;
        $output = exec("C:\python\python.exe $pythonScriptPath $arg");
        $cmd = "C:\python\python.exe $pythonScriptPath $arg";
        $data = [$arg, $output];
        return $output;
    }

    public function shippingManagementAjax(Request $request)
    {
        $jsonData = $request->input('selectedData');
        $pattern = '/W(\d+)D(\d+)H(\d+)/';
        $resultString = '';
        foreach ($jsonData as $item) {
            $namItem = $item['namItem'];
            if (preg_match($pattern, $namItem, $matches)) {
                $resultString .= "W{$matches[1]}D{$matches[2]}H{$matches[3]} ";
            }
        }
        $resultString = ' -b ' . rtrim($resultString);
        $searchtype = $request->input('searchtype');
        $pallet = $request->input('pallet');
        $this->deletePalletFile();
        $request = $this->palletPython($resultString, $searchtype, $pallet);
        return response()->json($request);
    }
    public function shippingManagementAjax2(Request $request)
    {
        $box1 = $request->input('box1');
        $modal = DB::select("SELECT COD_ITEMS FROM mes_mbom WHERE COD_ITEM = '$box1'");
        $resultString ='';
        foreach ($modal as $key => $value) {
            if (substr($value->COD_ITEMS, 0, 3) === "72-" ) {
                   
                $box = DB::select("SELECT * FROM mes_lcst_parts WHERE COD_ITEM = '$value->COD_ITEMS' LIMIT 1");
                $pattern = '/W(\d+)D(\d+)H(\d+)/';
                if (preg_match($pattern, $box[0]->NAM_ITEM, $matches)) {
                    $resultString .= "W{$matches[1]}D{$matches[2]}H{$matches[3]} ";
                }
              
               break;
            }
         
        }
       
        $box2 = $request->input('box2');
        $modal = DB::select("SELECT COD_ITEMS FROM mes_mbom WHERE COD_ITEM = '$box2'");

        foreach ($modal as $key => $value) {
            if (substr($value->COD_ITEMS, 0, 3) === "72-" ) {
                   
                $box = DB::select("SELECT * FROM mes_lcst_parts WHERE COD_ITEM = '$value->COD_ITEMS' LIMIT 1");
                $pattern = '/W(\d+)D(\d+)H(\d+)/';
                if (preg_match($pattern, $box[0]->NAM_ITEM, $matches)) {
                    $resultString .= "W{$matches[1]}D{$matches[2]}H{$matches[3]} ";
                }                
               break;
            }
         
        }
        $box3 = $request->input('box3');
        $modal = DB::select("SELECT COD_ITEMS FROM mes_mbom WHERE COD_ITEM = '$box3'");

        foreach ($modal as $key => $value) {
            if (substr($value->COD_ITEMS, 0, 3) === "72-" ) {
                   
                $box = DB::select("SELECT * FROM mes_lcst_parts WHERE COD_ITEM = '$value->COD_ITEMS' LIMIT 1");
                $pattern = '/W(\d+)D(\d+)H(\d+)/';
                if (preg_match($pattern, $box[0]->NAM_ITEM, $matches)) {
                    $resultString .= "W{$matches[1]}D{$matches[2]}H{$matches[3]} ";
                }                
               break;
            }
         
        }
        $box4 = $request->input('box4');
        $modal = DB::select("SELECT COD_ITEMS FROM mes_mbom WHERE COD_ITEM = '$box4'");

        foreach ($modal as $key => $value) {
            if (substr($value->COD_ITEMS, 0, 3) === "72-" ) {
                   
                $box = DB::select("SELECT * FROM mes_lcst_parts WHERE COD_ITEM = '$value->COD_ITEMS' LIMIT 1");
                $pattern = '/W(\d+)D(\d+)H(\d+)/';
                if (preg_match($pattern, $box[0]->NAM_ITEM, $matches)) {
                    $resultString .= "W{$matches[1]}D{$matches[2]}H{$matches[3]} ";
                }                
               break;
            }
         
        }
        $resultString = ' -b ' . rtrim($resultString);
        $searchtype = $request->input('searchtype');
        $pallet = $request->input('pallet');
        $this->deletePalletFile();
        $request = $this->palletPython($resultString, $searchtype, $pallet);
        return response()->json($request);
    }
    public function deletePalletFile()
    {
        $folderPath = public_path('pallet');
        if (File::exists($folderPath)) {
            $files = File::allFiles($folderPath);
            foreach ($files as $file) {
                File::delete($file);
            }
            return "删除。";
        }
        return "没有删除。";
    }
}
