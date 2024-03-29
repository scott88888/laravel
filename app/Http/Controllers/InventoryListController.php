<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Services\LangService;
use Illuminate\Support\Facades\File;


class InventoryListController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }

    public function inventoryListUpload(Request $request)
    {
        $lang = app()->getLocale();
        $page ='inventoryListUpload';
        $langArray = $this->langService->getLang($lang,$page);
        $page ='sidebar';
        $sidebarLang = $this->langService->getLang($lang,$page);   
        return view('inventoryListUpload', compact('langArray','sidebarLang'));
    }

    public function importCsv(Request $request)
    {
        if ($request->country) {
            $value = DB::select("SELECT * FROM mes_stockcsv WHERE country = '$request->country' GROUP BY TIME ORDER BY TIME DESC");
            $time = $value[0]->time;
            $today = now()->format('Y-m-d');
            if ( $time ==$today) {
                DB::table('mes_stockcsv')->where('country', $request->country)->where('time', $today)->delete();
            }
        }

        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $time = now();
            foreach ($data as $row) {
                DB::table('mes_stockcsv')->insert([
                    'modal' => $row[0],
                    'description' => $row[1],
                    'stock' => $row[2],
                    'country' => $request->country,
                    'time' => $time,
                ]);
            }
            $filename = $request->country.'inventory';
    
            $destinationPath = public_path('csv_files/' . $filename . '.csv');
            File::move($path, $destinationPath);
            
            // 檢查是否成功移動檔案
            if (File::exists($destinationPath)) {
               return redirect()->back()->with('success', 'CSV 檔案已匯入');
            } else {
                // 移動失敗的處理邏輯
                dd('Move failed');
            }

          
        }
      
        return redirect()->back()->with('error', '請選擇一個 CSV 檔案');
    }

    public function inventoryList(Request $request)
    {
        
        $country = $request->query('country');         
        $value = DB::select("SELECT * FROM mes_stockcsv WHERE country = '$country' GROUP BY TIME ORDER BY TIME DESC");
        $time = $value[0]->time;
        $inventoryList =  DB::select("SELECT * FROM mes_stockcsv WHERE country = '$country' and time = '$time'");


        $lang = app()->getLocale();
        $page ='inventoryList';
        $langArray = $this->langService->getLang($lang,$page);
        $page ='sidebar';
        $sidebarLang = $this->langService->getLang($lang,$page);

        return view('inventoryList', compact('inventoryList','time','country','langArray','sidebarLang'));
       

    }
}
