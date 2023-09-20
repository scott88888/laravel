<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

use DB;
use Illuminate\Http\Request;

class salesManagementController extends BaseController
{

    public function shippingManagement()
    {
        $shippingManagement = DB::select("SELECT * FROM `mes_lcst_parts` WHERE  COD_ITEM LIKE '72%' GROUP BY COD_ITEM");        
        return view('shippingManagement', ['shippingManagement' => $shippingManagement]);
    }

    public function palletPython($resultString,$searchtype,$pallet)
    {
        $pythonScriptPath = 'C:\xampp\htdocs\3DBinPacking\pallet.py';
        $arg = '-t '.$searchtype .' -c ' .$pallet .$resultString;
        $output = exec("C:\python\python.exe $pythonScriptPath $arg");
        $cmd = "C:\python\python.exe $pythonScriptPath $arg";
        $data =[$arg,$output]; 
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
        $resultString = ' -b ' .rtrim($resultString);
        $searchtype = $request->input('searchtype'); 
        $pallet = $request->input('pallet'); 
        $request = $this -> palletPython($resultString,$searchtype,$pallet);
        return response()->json($request);
    }
}
