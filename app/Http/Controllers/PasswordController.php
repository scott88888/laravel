<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\LangService;



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
        $page = 'passwordupdate';
        $langArray = $this->langService->getLang($lang, $page);
        $page = 'sidebar';
        $sidebarLang = $this->langService->getLang($lang, $page);
        return view('userSetup', compact('langArray', 'sidebarLang'));
   
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
}
