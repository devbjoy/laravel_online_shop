<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function changeAdminPassword(){
        return view('admin.change-password');
    }

    public function processAdminChangePassword(Request $request)
    {
        $validate = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validate){
            $user = Auth::guard('admin')->user();

            if(!Hash::check($request->old_password,$user->password)){
                return redirect()->route('admin.changeAdminPassword')->with('error','Your password is incurrect, please try again');
            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('admin.changeAdminPassword')->with('success','Your password updated successfully');
        }
    }
}
