<?php
// app/Http/Controllers/FileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\FileModel;
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
                'createDate' => date('Y-m-d H:i:s')
            ];
            DB::table('mes_ecrecn')
            ->where('id',$data['id'])
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
        }else {
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
                'repairOrderNum' => $request->input('repairOrderNum'),
                'repairOrder' => $request->input('repairOrder')
            ];
            $request = FileModel::ECNPMupdate($data);
            DB::table('mes_ecrecn')
            ->where('id',$data['listid'])
            ->update([
                'modificationDate' => $data['modificationDate'],
                'orderNumber' => $data['orderNumber'],
                'serialNumber' => $data['serialNumber'],
                'closeCase' => $data['closeCase'],
                'deliveryOrder' => $data['deliveryOrder'],
                'repairOrderNum' => $data['repairOrderNum'],
                'repairOrder' => $data['repairOrder'],
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
}
