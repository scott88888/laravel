<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;




class PasswordController extends Controller
{
    public function showUpdateForm()
    {
        return view('password.update');
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

            return redirect()->route('password.update')->with('success', 'Password updated successfully.');
        } else {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
    }
}
