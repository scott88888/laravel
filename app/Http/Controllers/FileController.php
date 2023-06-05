<?php
// app/Http/Controllers/FileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;

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
        
$searchClientType = $request->input('searchClientType');
$searChproductType = $request->input('searChproductType');
$lilinVersion = $request->input('lilinVersion');
$MOD = $request->input('MOD');
$productName = $request->input('productName');
$customerName = $request->input('customerName');
$customerType = $request->input('customerType');
$lensMCU = $request->input('lensMCU');
$lensISP = $request->input('lensISP');
$rescueVersion = $request->input('rescueVersion');
$AI_Version = $request->input('AI_Version');
$inspectionForm = $request->input('inspectionForm');

$value =DB::table('fw_index')->insert([
    'fw_id' => '',
    'version' => $lilinVersion,
    'ai_ver' => $AI_Version,
    'pantilt_ver' => '',
    'lens_ver' => $lensMCU,
    'lens_parameter' => $lensISP,
    'ipcam_lens_mcu' => '',
    'ipcam_lens_isp' => '',
    'p_ver' => '',
    'recovery_ver' => $rescueVersion,
    'customer' => $searchClientType,
    'customer_oem' => $customerName,
    'model_customer' => $customerType,
    'model_no' => $MOD,
    'model_name' => $productName,
    'product_type' => $searChproductType,
    'file_kernel' => 'V',
    'file_kernel_url' => 'upload/1.1(testM)_nameTest_1.1(testV)_typeTest_LILIN/flashssc327a.zip',
    'file_app' => 'V',
    'file_app_url' => 'upload/1.1(testM)_nameTest_1.1(testV)_typeTest_LILIN/DataTables.zip',
    'file_note_text' => '',
    'file_note_text_url' => '',
    'file_note_pdf' => '',
    'file_note_pdf_url' => '',
    'file_other' => 'V',
    'file_other_url' => 'upload/1.1(testM)_nameTest_1.1(testV)_typeTest_LILIN/Plsqldev715.rar',
    'file_report' => 'V',
    'file_report_url' => 'upload/1.1(testM)_nameTest_1.1(testV)_typeTest_LILIN/FU+ 共學_20230413(進階)美股投資學_Jenny老師.pdf',
    'ow_url' => 'upload/703_E5R9252AX_9.0.001.3830_E5R9252AX_NoBrand/703_E5R9252AX_9.0.001.3830_E5R9252AX_NoBrand_20221222.zip',
    'url' => '',
    'checksum' => '',
    'upload_date' => '2022-12-22 15:29:45',
    'Remark' => $inspectionForm,
    'upload_man' => 'J04',
    'upload_man2' => '',
    'upload_date2' => '0000-00-00 00:00:00',
    'fw_status' => 0
]);

// searchClientType
// searChproductType
// lilinVersion
// MOD
// productName
// customerName
// customerType
// lensMCU
// lensISP
// rescueVersion
// AI_Version
// inspectionForm
return response()->json($value);

//return response()->json($searchClientType,$searChproductType,$lilinVersion,$MOD,$productName,$customerName,$customerType,$lensMCU,$lensISP,$rescueVersion,$AI_Version,$inspectionForm);

    }

    public function uploadFile(Request $request)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 調用建立目錄函數

        // 上傳檔案的目標路徑和檔名
        $directory = 'aaa';
      
        $ftpFilename = "test" . $_FILES['file']['name'];
        $ftpFilename =urlencode($ftpFilename);
      

        // 建構 cURL 請求
        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}{$ftpFilePath}");
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
            return response()->json(['message' => '上傳成功', 'path' => 'File name: ' . $ftpFilename]);
        }

        // 關閉 cURL
        curl_close($curl);
    }

    // 建立目錄
    private function createDirectory($ftpHost, $ftpUsername, $ftpPassword, $directory)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}");
        curl_setopt($curl, CURLOPT_PORT, 57);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'MKD');
        curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        return $statusCode;
    }


    
}
