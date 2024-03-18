<?php

namespace App\Http\Controllers;


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
        return view('shippingManagement', compact('shippingManagement','modal', 'langArray', 'sidebarLang'));


        
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
