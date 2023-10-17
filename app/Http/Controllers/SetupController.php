<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Services\LangService;
use DB;
use Illuminate\Http\Request;

class SetupController extends BaseController
{
    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }
    public function userLoginLog()
    {
        $lang = app()->getLocale();
        $page = 'userLoginLog';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);



        $value = DB::SELECT("SELECT * FROM mes_loginlog
        WHERE NOT log_url LIKE 'show-image%'");
        return view('userLoginLog', compact('value', 'langArray', 'sidebarLang'));
    }

    public function userCheckPermission()
    {
        $lang = app()->getLocale();
        $page = 'userCheckPermission';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        return view('userCheckPermission', compact('langArray', 'sidebarLang'));
    }
    public function userSearchIDAjax(Request $request)
    {

        $employee_id = $request->input('searchID');
        if ($employee_id) {
            $suerData =  DB::select("SELECT *
                FROM mes_check_permission
                WHERE employee_id = '$employee_id'");

            if (!empty($suerData)) {
                return response()->json($suerData);
            } else {
                return response()->json(['error' => '查無資料'], 404);
            }
        }

        return response()->json(['error' => '查無資料'], 400);
    }

    public function userUpdatePermissionAjax(Request $request)
    {
        $employee_id = $request->input('searchID');
        $pageID = $request->input('selectedCheckboxIds');
        $default = $request->input('default');
        $pageIDAsString = implode(',', $pageID);


        if ($employee_id && $pageID) {
            // 先刪除現有的記錄
            DB::table('mes_check_permission')->where('employee_id', $employee_id)->delete();
            // 插入新記錄
            $insert = DB::table('mes_check_permission')->insert([
                'employee_id' => $employee_id,
                'permission' => $pageIDAsString,
                'default' => $pageID[0]
            ]);
            if ($insert) {
                return response()->json(['success' => true, 'message' => '權限更新成功']);
            } else {
                return response()->json(['success' => false, 'message' => '權限更新失敗']);
            }
        }
        return response()->json($pageID);
    }

    public function userEdit()
    {
        $userEdit = DB::select("SELECT 
                                    U.name,U.employee_id,U.email,
                                    LENGTH(M.permission COLLATE utf8_general_ci) - LENGTH(REPLACE(M.permission COLLATE utf8_general_ci, ',', '')) + 1 AS number_count
                                FROM mes_check_permission M
                                INNER JOIN users U ON M.employee_id = U.employee_id COLLATE utf8_general_ci;");

        $lang = app()->getLocale();
        $page = 'userEdit';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('userEdit', compact('userEdit','langArray', 'sidebarLang'));
    }
    public function userEditPer(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'userEditPer';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);

        
        $employee_id = $request->id;
        if ($employee_id) {
            return view('userEditPer', compact('employee_id', 'langArray', 'sidebarLang'));
        }
    }
    public function userDeleteAjax(Request $request)
    {
        $employee_id = $request->searchID;
        $delemployee_id = DB::table('mes_check_permission')->where('employee_id', $employee_id)->delete();
        if ($delemployee_id) {
            return response()->json('刪除成功');
        }
    }
}
