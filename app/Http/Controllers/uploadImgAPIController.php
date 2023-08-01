<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class uploadImgAPIController extends Controller
{
    public function upload(Request $request)
    {
        // 取得 JSON 格式的請求內容
        //$data = $request->json()->all();

        // 從 JSON 資料中取得 base64 圖片資料


        // 解析 base64 圖片資料並儲存圖片到適當的位置
        // 實作處理圖片的邏輯...

        if ($request->query('target')) {
            $target = $request->query('target');
            switch ($target) {
                case 'mesProductionResumeList':
                    $data = $request->json()->all();
                    $base64Image = $data['snap_image'];
                    $insertedId = DB::table('mes_uploadimg')->insertGetId([
                        'img' => $base64Image
                    ]);
                    return response()->json(['message' => 'url=showImg?target='. $target.'&id='. $insertedId ], 200);
                    break;
                default:
                    return response()->json(['message' => 'error' . $target], 200);
            }
        } else {
            return response()->json(['message' => 'error name'], 200);
        }

    }

    public function show(Request $request)
    {

        if ($request->query('id') & $request->query('target')) {

            $image = DB::table('mes_uploadimg')->where('id', $request->query('id') )->first(); // 假設 $id 是您要查詢的圖片資料的 ID
            $base64Image = $image->img; // 取出 base64 字串
            $decodedImage = base64_decode($base64Image);        
            return response($decodedImage)->header('Content-Type', 'image/jpeg');
        }
    }
}
