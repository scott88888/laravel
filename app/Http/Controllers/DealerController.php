<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;


use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\DealerUserModel;
use Illuminate\Http\Request;


class DealerController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $langService;
    public function Dealer(Request $request)
    {

        return view('dealerLogin');
    }

    public function DealerCheckLogin(Request $request)
    {
        $dealerId = $request->input('dealer_id');
        $password = $request->input('password');

        // 在資料庫中驗證帳號密碼
        $user = DealerUserModel::where('COD_FACT', $dealerId)
            ->where('NUM_REG', $password)
            ->first();

        if ($user) {

            return redirect()->route('dealerMSDS');
       
        } else {
            // 驗證失敗
            return view('dealerLogin');
        }
        // return view('DealerMsds');

    }

    public function dealerMSDS(Request $request)
    {
        $casCode = DB::select(" SELECT * FROM mes_msds_cas");
        return view('dealerMSDS', compact('casCode'));
        
    }
    public function DealerMSDSAjax(Request $request)
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
    public function DealerCasCodeSearchAjax(Request $request)
    {

        $casCode = $request->input('casCode');
        $data = DB::select(" SELECT * FROM mes_msds_cas WHERE CASNo = '$casCode' ");

        if ($data) {
            return response()->json($data);
        }
    }

    public function DealerCasInsertAjax(Request $request)
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

    public function DealerSelectMSDSAjax(Request $request)
    {

        $modalValue = $request->input('modalValue');
        $COD_FACT = $request->input('COD_FACT');

        $data = DB::select("SELECT mes_msds_list.* ,mes_msds_part.COD_ITEM,mes_msds_part.partWeight, (mes_msds_part.partWeight * mes_msds_list.content / 100 ) AS weight FROM mes_msds_list
        LEFT JOIN mes_msds_part ON mes_msds_list.COD_FACT = mes_msds_part.COD_FACT
        WHERE mes_msds_list.COD_FACT = '$COD_FACT' AND mes_msds_list.partNumber = '$modalValue' AND mes_msds_part.COD_ITEM ='$modalValue' ");

        return response()->json($data);
    }
    public function DealerDelMSDSAjax(Request $request)
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
    public function DealerMSDSupdateWeightAjax(Request $request)
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

    public function DealerMSDSCopyListAjax(Request $request)
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

    public function DealerMSDSCopyAjax(Request $request)
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

    public function DealerEditMSDSAjax(Request $request)
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
