<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


use Throwable;
use DB;
use Illuminate\Http\Request;

class AutoUpdateController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function mesAutoUpdate(Request $request)
    {


        
        $date = date('ymd');
        $data = 'MR' . $date . '%';
        // 讀取資料
        $runcard_ng_rate = DB::connection('mysql_second')
            ->table('runcard_ng_rate')
            ->where('num_comr', 'LIKE', $data)
            ->get();
        if ($runcard_ng_rate->count() != 0) {
            DB::table('runcard_ng_rate')->where('num_comr', 'LIKE', $data)->delete();            
            foreach ($runcard_ng_rate as $data) {
                try {
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
                } catch (Throwable $e) {
                    // 發生錯誤時的處理邏輯
                    $msg='錯誤'.date('His').$e->getMessage();
                    $this->writeLog($msg);
                }
            }
        }
    }


    public function writeLog($msg)
    {
        $date = date('ymd');

        $logFileDirectory = 'log/'; // 目錄路徑
        $logFilePath = $logFileDirectory . $date . '.txt'; // 完整檔案路徑        
        // 建立目錄
        if (!is_dir($logFileDirectory)) {
            mkdir($logFileDirectory, 0777, true); // 第三個參數設為 true 可以遞迴地建立目錄
        }

        // 建立檔案並寫入內容
        file_put_contents($logFilePath, $msg . PHP_EOL, FILE_APPEND);
    }
}
