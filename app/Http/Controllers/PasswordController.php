<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\LangService;
use App\Models\User;
use DB;

class PasswordController extends Controller
{
    protected $langService;

    public function __construct(LangService $langService)
    {
        $this->langService = $langService;
    }

    public function showUpdateForm()
    {

        $lang = app()->getLocale();
        $page = 'userSetup';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $user = Auth::user();
        $def_pass = $user->def_pass;
        return view('userSetup', compact('langArray', 'sidebarLang','def_pass'));
   
    }

    public function update(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:4',
        ]);
        

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->updated_at = now();
            $user->def_pass = $request->password;
            $user->save();
     
            return $this->showUpdateForm();
        } else {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect']);
        }
    }
    public function userCreate(Request $request)
    {
        $lang = app()->getLocale();
        $page = 'userSetup';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        $user = Auth::user(); 
        return view('userCreate', compact('langArray', 'sidebarLang'));

    }

    public function userCreateAccount(Request $request)
    {
       
        if ($request->employee_id && $request->name) {
            // 檢查是否已存在相同的 employee_id
            $existingUser = User::where('employee_id', $request->employee_id)->first();
        
            if (!$existingUser) {
                $user = User::create([
                    'employee_id' => $request->employee_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'email_verified_at' => now(),
                    'password' => Hash::make('pass'),
                    'updated_at' => now(),
                    'def_pass' => 'pass',
                    'type' => 1,
                ]);
        
                $insert = DB::table('mes_check_permission')->insert([
                    'employee_id' => $request->employee_id,
                    'name' => $request->name,
                    'permission' => 26,
                    'default' => 26,
                    'lang_default' => 'zh'
                ]);
        
                return $this->userCreate($request);
            } else {
             
                return response()->json(['error' => 'Employee ID already exists'], 422);
            }
        }
    }
}
