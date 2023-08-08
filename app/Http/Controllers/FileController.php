<?php
// app/Http/Controllers/FileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\FileModel;
use DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class FileController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function fileFirmwareUpload(Request $request)
    {
        return view('fileFirmwareUpload');
    }

    public function fileFirmwareUploadAjax(Request $request)
    {


        $dbInserturl =  $file_kernel_url = $request->input('MOD') . '_' . $request->input('productName') . '_' . $request->input('lilinVersion') . '_' . $request->input('customerType') . '_' . $request->input('searchClientType');
        $firmwareOS_Name = $request->input('firmwareOS_Name');
        $firmwareAPP_Name = $request->input('firmwareAPP_Name');
        $checkReport_Name = $request->input('checkReport_Name');
        $otherFiles_Name = $request->input('otherFiles_Name');

        if ($firmwareOS_Name == null) {
            $file_kernel_url = null;
        } else {
            $file_kernel_url = 'upload/' . $dbInserturl . '/' . $firmwareOS_Name;
        }

        if ($firmwareAPP_Name == null) {
            $file_app_url = null;
        } else {
            $file_app_url = 'upload/' . $dbInserturl . '/' . $firmwareAPP_Name;
        }

        if ($checkReport_Name == null) {
            $file_report_url = null;
        } else {
            $file_report_url = 'upload/' . $dbInserturl . '/' . $checkReport_Name;
        }

        if ($otherFiles_Name == null) {
            $file_other_url = null;
        } else {
            $file_other_url = 'upload/' . $dbInserturl . '/' . $otherFiles_Name;
        }

        $data = [
            'fw_id' => $request->input('fw_id'),
            'username' => Auth::user()->employee_id,
            'searchClientType' => $request->input('searchClientType'),
            'searChproductType' => $request->input('searChproductType'),
            'lilinVersion' => $request->input('lilinVersion'),
            'MOD' => $request->input('MOD'),
            'productName' => $request->input('productName'),
            'customerName' => $request->input('customerName'),
            'customerType' => $request->input('customerType'),
            'lensMCU' => $request->input('lensMCU'),
            'lensISP' => $request->input('lensISP'),
            'AI_Version' => $request->input('AI_Version'),
            'inspectionForm' => $request->input('inspectionForm'),
            'dbInserturl' =>  $dbInserturl,
            'upload_date' => date('Y-m-d H:i:s'),
            'file_kernel_url' => $file_kernel_url,
            'file_app_url' => $file_app_url,
            'file_report_url' => $file_report_url,
            'file_other_url' => $file_other_url,
            'PanTilt_ver' =>  $request->input('PanTilt_ver'),
            'P_ver' =>  $request->input('P_ver')
        ];
        if ($request->input('fw_id') > 0) {
            $value = FileModel::fwindexUpdate($data);
        } else {
            $value = FileModel::fwindexInsert($data);
        }
        return response()->json($request->input('PanTilt_ver'));
    }


    public function uploadFile(Request $request)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 調用建立目錄函數

        // 上傳檔案的目標路徑和檔名，大小
        $directory = $request->input('MOD') . '_' . $request->input('productName') . '_' . $request->input('lilinVersion') . '_' . $request->input('customerType') . '_' . $request->input('searchClientType');
        //$directory = 'aaa';

        $ftpFilename = $_FILES['file']['name'];
        $ftpFilename = urlencode($ftpFilename);

        $filesize = $_FILES['file']['size'];
        $filesize = $this->formatFileSize($filesize);
        // 建構 cURL 請求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}/{$ftpFilename}");
        curl_setopt($curl, CURLOPT_PORT, 57);
        curl_setopt($curl, CURLOPT_UPLOAD, true);
        curl_setopt($curl, CURLOPT_INFILE, fopen($_FILES['file']['tmp_name'], 'r'));
        curl_setopt($curl, CURLOPT_INFILESIZE, $_FILES['file']['size']);
        curl_setopt($curl, CURLOPT_FTP_CREATE_MISSING_DIRS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // 執行 cURL 請求
        $response = curl_exec($curl);

        if ($response === false) {
            return response()->json(['message' => '上傳失敗'], 400);
        } else {
            return response()->json(['message' => '上傳成功', 'filename' => $ftpFilename, 'filesize' => $filesize]);
        }

        // 關閉 cURL
        curl_close($curl);
    }

    public function fileECNEdit(Request $request)
    {
        return view('fileECNEdit');
    }

    public function fileECNCreateAjax(Request $request)
    {


        $data = [
            'id' => '',
            'ECRNum' => $request->input('ECRNum'),
            'applyDate' => $request->input('applyDate'),
            'ECNNum' => $request->input('ECNNum'),
            'noticeDate' => $request->input('noticeDate'),
            'model' => $request->input('model'),
            'reason' => $request->input('reason'),
            'approved' => $request->input('approved'),
            'charge' => $request->input('charge'),
            'remark' => $request->input('remark'),
            'deliveryOrder' => $request->input('deliveryOrder'),
            'createDate' => date('Y-m-d H:i:s')
        ];
        FileModel::ECNCreate($data);
        return response()->json(['ok' => $request]);
    }
    public function fileECRNEditAjax(Request $request)
    {
        if ($request->input('listid')) {
            //DB::table('mes_ecrecn')->where('id', $request->input('listid'))->delete();
            $data = [
                'id' => $request->input('listid'),
                'ECRNum' => $request->input('ECRNum'),
                'applyDate' => $request->input('applyDate'),
                'ECNNum' => $request->input('ECNNum'),
                'noticeDate' => $request->input('noticeDate'),
                'model' => $request->input('model'),
                'reason' => $request->input('reason'),
                'approved' => $request->input('approved'),
                'charge' => $request->input('charge'),
                'remark' => $request->input('remark'),
                'repairOrderNum' => $request->input('repairOrderNum'),
                'createDate' => date('Y-m-d H:i:s')
            ];
            DB::table('mes_ecrecn')
                ->where('id', $data['id'])
                ->update([
                    'id' => $data['id'],
                    'ECRNum' => $data['ECRNum'],
                    'applyDate' => $data['applyDate'],
                    'ECNNum' => $data['ECNNum'],
                    'noticeDate' => $data['noticeDate'],
                    'model' => $data['model'],
                    'reason' => $data['reason'],
                    'approved' => $data['approved'],
                    'charge' => $data['charge'],
                    'remark' => $data['remark'],
                    'repairOrderNum' => $data['repairOrderNum'],
                    'createDate' => $data['createDate']
                ]);
            return response()->json(['ok' => $request]);
        }
    }

    public function delECRNAjax(Request $request)
    {
        if ($request->input('listid')) {
            $delId = DB::table('mes_ecrecn')->where('id', $request->input('listid'))->delete();
        }

        if ($delId) {
            return response()->json(['ok' => $delId]);
        } else {
            return response()->json(['error' => $delId]);
        }
    }

    public function fileECRNEditPMAjax(Request $request)
    {
        if ($request->input('listid')) {
            $data = [
                'listid' => $request->input('listid'),
                'modificationDate' => $request->input('modificationDate'),
                'orderNumber' => $request->input('orderNumber'),
                'serialNumber' => $request->input('serialNumber'),
                'closeCase' => $request->input('closeCase'),
                'deliveryOrder' => $request->input('deliveryOrder'),
                'repairOrderNum' => $request->input('repairOrderNum')
            ];
            $request = FileModel::ECNPMupdate($data);
            DB::table('mes_ecrecn')
                ->where('id', $data['listid'])
                ->update([
                    'modificationDate' => $data['modificationDate'],
                    'orderNumber' => $data['orderNumber'],
                    'serialNumber' => $data['serialNumber'],
                    'closeCase' => $data['closeCase'],
                    'deliveryOrder' => $data['deliveryOrder'],
                    'repairOrderNum' => $data['repairOrderNum']
                ]);
            return response()->json(['ok' => $request]);
        }
    }

    public function ECNuploadFile(Request $request)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 調用建立目錄函數
        if ($request->input('formId') == 'ECRpdfForm') {
            // 上傳檔案的目標路徑和檔名，大小
            $directory = 'RD_ECRECN/ECR';
        } else {
            $directory = 'RD_ECRECN/ECN';
        }

        $ftpFilename = $_FILES['file']['name'];
        $ftpFilename = urlencode($ftpFilename);

        $filesize = $_FILES['file']['size'];
        $filesize = $this->formatFileSize($filesize);
        // 建構 cURL 請求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}/{$ftpFilename}");
        curl_setopt($curl, CURLOPT_PORT, 57);
        curl_setopt($curl, CURLOPT_UPLOAD, true);
        curl_setopt($curl, CURLOPT_INFILE, fopen($_FILES['file']['tmp_name'], 'r'));
        curl_setopt($curl, CURLOPT_INFILESIZE, $_FILES['file']['size']);
        curl_setopt($curl, CURLOPT_FTP_CREATE_MISSING_DIRS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // 執行 cURL 請求
        $response = curl_exec($curl);

        if ($response === false) {
            return response()->json(['message' => '上傳失敗'], 400);
        } else {
            return response()->json(['message' => '上傳成功', 'filename' => $ftpFilename, 'filesize' => $filesize]);
        }

        // 關閉 cURL
        curl_close($curl);
    }

    public function  formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }

    public function uploadjpg(Request $request)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 建立目錄/檔名
        $model = $request->input('idModel');
        $directory = $request->input('type') . "/" . $model;
        $ftpFilename = $model  . '.jpg';

        // 上傳檔案到 FTP 伺服器
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}/{$ftpFilename}");
        curl_setopt($curl, CURLOPT_PORT, 57);
        curl_setopt($curl, CURLOPT_UPLOAD, true);
        curl_setopt($curl, CURLOPT_INFILE, fopen($_FILES['file']['tmp_name'], 'r'));
        curl_setopt($curl, CURLOPT_INFILESIZE, $_FILES['file']['size']);
        curl_setopt($curl, CURLOPT_FTP_CREATE_MISSING_DIRS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            return response()->json(['message' => '上傳失敗'], 400);
        }

        // 建立縮圖
        $uploadedFileTmpPath = $_FILES['file']['tmp_name'];
        $thumbnail = Image::make($uploadedFileTmpPath)->fit(200)->encode('jpg');

        // 指定縮圖儲存的路徑和檔名
        $thumbnailFilename = $model  . '-s.jpg'; // 你可以根據需求自定義縮圖的名稱

        // 將縮圖內容寫入臨時檔案
        $tmpThumbnailPath = tempnam(sys_get_temp_dir(), 'thumbnail');
        file_put_contents($tmpThumbnailPath, $thumbnail);

        // 使用 cURL 將縮圖上傳至 FTP 伺服器
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}/{$thumbnailFilename}");
        curl_setopt($ch, CURLOPT_PORT, 57);
        curl_setopt($ch, CURLOPT_UPLOAD, true);
        curl_setopt($ch, CURLOPT_INFILE, fopen($tmpThumbnailPath, 'r')); // 使用 fopen 開啟縮圖檔案來源
        curl_setopt($ch, CURLOPT_INFILESIZE, strlen($tmpThumbnailPath)); // 使用 strlen 獲取縮圖檔案大小
        curl_setopt($ch, CURLOPT_FTP_CREATE_MISSING_DIRS, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        // 返回 JSON 响應，包含上傳成功信息、檔案名稱和檔案大小
        $filesize = $this->formatFileSize($_FILES['file']['size']);
        $table = 'mes_' . $request->input('type') . '_uploadimg';
        $this->uploadJpgToSql($table, $model);
        return response()->json([
            'message' => '上傳成功',
            'filename' => $ftpFilename,
            'filesize' => $filesize,
            'thumbnail_path' => $directory,
            'thumbnail_name' => $thumbnailFilename
        ]);
    }
    public function uploadJpgToSql($table, $model)
    {

        $create_time = Carbon::now();
        $select = DB::table($table)
            ->where('model', '=', $model)
            ->get();
        if (count($select) > 0) {

            $value = DB::table($table)
                ->where('model', '=', $model)
                ->update([
                    'model' => $model,
                    'type' => 1,
                    'img' =>  $model . '.jpg',
                    'simg' =>  $model . '-s.jpg',
                    'create_time' => $create_time
                ]);
        } else {
            $value = DB::table($table)->insert([
                'id' => '',
                'model' => $model,
                'type' => 1,
                'img' =>  $model . '.jpg',
                'simg' =>  $model . '-s.jpg',
                'create_time' => $create_time
            ]);
        }


        return $value;
    }
    public function delJpgAjax(Request $request)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 刪除的目錄
        $model = $request->input('delid');
        $directory = "mesItemPartList/98-AHD3421S1Y1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}");
        curl_setopt($ch, CURLOPT_PORT, 57);
        curl_setopt($ch, CURLOPT_QUOTE, array("RMD {$directory}")); // 使用 RMD FTP 指令刪除資料夾
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FTP_USE_EPSV, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'message' => $result
        ]);
    }
}
