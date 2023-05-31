<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\FileModelList;




class FileController extends Controller
{

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');         
            $disk = 'public';                   
            $path = $file->storeAs('upload', $file->getClientOriginalName(), $disk);
        
            return response()->json(['message' => '文件上传成功', 'path' => $path]);
        }
        
        return response()->json(['message' => '未选择文件或上传失败'], 400);
        
    }


    public function fileFirmwareUpload(Request $request)
    {
        //http://192.168.0.123/support/www/MES/lilin/upload/701_E5R9152A_9.0.001.3830_E5R9152A_LILIN/flashssc327a.zip
        // mklink /d C:\xampp\htdocs\laravel\public\storage Z:\www\MES\lilin

        return view('fileFirmwareUpload');
    }
}
