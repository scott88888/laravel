<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Services\LangService;
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
                    'stock' => $row[1],
                    'country' => $request->country,
                    'time' => $time,
                ]);
            }
            return redirect()->back()->with('success', 'CSV 檔案已匯入');
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
