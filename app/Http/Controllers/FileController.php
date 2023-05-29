<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('public/uploads', $file->getClientOriginalName());


            return response()->json(['success' => '檔案上傳成功']);
        } else {
            return response()->json(['error' => '沒有選擇檔案']);
        }
    }
}
