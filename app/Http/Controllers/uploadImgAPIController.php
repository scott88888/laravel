<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Intervention\Image\Facades\Image;
use App\Models\UploadImgAPIModel;
use Carbon\Carbon;




class uploadImgAPIController extends Controller
{
    public function upload(Request $request)
    {
        try {
            if ($request->query('target')) {
                $target = $request->query('target');
                $data = $request->json()->all();

                $base64Image = $data['snap_image'];
                $imageData = base64_decode($base64Image);
                $model = $data['model'];
                $table = 'mes_' . $target . '_uploadimg';
                $create_time = Carbon::now();
                $getJpgLog = UploadImgAPIModel::getJpgLog($target, $model);
                if (count($getJpgLog) > 0) {
                    $fileName = $model . '-' . Carbon::now()->format('Y-m-d-H-i-s');
                    //寫入原圖
                    $this->uploadjpg($target, $model, $imageData, $fileName);
                    DB::table($table)->insert([
                        'id' => '',
                        'model' => $model,
                        'type' => 2,
                        'img' =>  $fileName . '.jpg',
                        'simg' =>  $fileName . '-s.jpg',
                        'create_time' => $create_time,
                        'first' => 0
                    ]);                
                } else {
                    $fileName = $model;
                    //寫入原圖
                    $this->uploadjpg($target, $model, $imageData, $fileName);
                    //寫入縮圖
                    $this->uploadSjpg($target, $model, $imageData);
                    DB::table($table)->insert([
                        'id' => '',
                        'model' => $fileName,
                        'type' => 2,
                        'img' =>  $model . '.jpg',
                        'simg' =>  $model . '-s.jpg',
                        'create_time' => $create_time,
                        'first' => 1
                    ]);
                }
                return response()->json(['message' => $fileName], 200);
            } else {
                return response()->json(['message' => 'data error'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'json data error'], 500);
        }
    }

    public function show(Request $request)
    {

        if ($request->query('id') & $request->query('target')) {
            $image = DB::table('mes_uploadimg')->where('id', $request->query('id'))->first(); // 假設 $id 是您要查詢的圖片資料的 ID
            $base64Image = $image->img; // 取出 base64 字串
            $decodedImage = base64_decode($base64Image);
            return response($decodedImage)->header('Content-Type', 'image/jpeg');
        }
    }

    public function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }

    public function uploadjpg($target, $model, $imageData, $fileName)
    {
        // FTP 伺服器的主機地址、使用者名稱和密碼
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';

        // 建立目錄/檔名

        $directory = $target . "/" . $model;
        $ftpFilename = $fileName  . '.jpg';

        // 將圖內容寫入臨時檔案
        $imageDataPath = tempnam(sys_get_temp_dir(), 'imageData');
        file_put_contents($imageDataPath, $imageData);

        // 上傳檔案到 FTP 伺服器
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "ftp://{$ftpUsername}:{$ftpPassword}@{$ftpHost}/{$directory}/{$ftpFilename}");
        curl_setopt($curl, CURLOPT_PORT, 57);
        curl_setopt($curl, CURLOPT_UPLOAD, true);
        curl_setopt($curl, CURLOPT_INFILE, fopen($imageDataPath, 'r'));
        curl_setopt($curl, CURLOPT_INFILESIZE, strlen($imageData));
        curl_setopt($curl, CURLOPT_FTP_CREATE_MISSING_DIRS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            return response()->json(['message' => '上傳失敗'], 400);
        }
    }

    public function uploadSjpg($target, $model, $imageData)
    {
        $ftpHost = '192.168.0.3';
        $ftpUsername = 'E545';
        $ftpPassword = 'SCSC';


        // 建立目錄/檔名
        $directory = $target . "/" . $model;
        // 指定縮圖儲存的路徑和檔名
        $thumbnailFilename = $model  . '-s.jpg'; // 你可以根據需求自定義縮圖的名稱


        // 建立縮圖
        $uploadedFileTmpPath = $imageData;
        $thumbnail = Image::make($uploadedFileTmpPath)->fit(200)->encode('jpg');


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
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return response()->json(['message' => '上傳失敗'], 400);
        }
    }
}
