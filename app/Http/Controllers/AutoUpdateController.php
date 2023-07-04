<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



use DB;
use Illuminate\Http\Request;

class AutoUpdateController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function mesAutoUpdate(Request $request)
    {
        // 讀取資料

        $date = date('ymd');
        $data = 'MR'.$date.'%';
        $runcard_ng_rate = DB::connection('mysql_second')
            ->table('runcard_ng_rate')
            ->where('num_comr', 'LIKE', $data)
            ->get();
        // 寫入資料
        foreach ($runcard_ng_rate as $data) {
            DB::table('runcard_ng_rate')->insert([
                'ng_id' => $data->ng_id,
                'num_comr' => $data->num_comr,
                'work_no' => $data->work_no,
                'order_qty' => $data->order_qty,
                'ng_qty' => $data->ng_qty,
                'ng_rate' => $data->ng_rate,
                'runcard_no' => $data->runcard_no,
                'pp_qty' => $data->pp_qty,
                'model' => $data->model,
                'version' => $data->version,
                'comr_user' => $data->comr_user,
                'cod_qc' => $data->cod_qc,
                'sts_comr' => $data->sts_comr
            ]);
        }

        // $value = DB::table('runcard_ng_rate')->where('num_comr', 'LIKE', 'MR230620%')->get();

        // $runcard_ng_rate = DB::connection('mysql_second')->table('runcard_ng_rate')->where('num_comr', 'LIKE', 'MR230620%')->get();
        // var_dump($value);
    }
}
