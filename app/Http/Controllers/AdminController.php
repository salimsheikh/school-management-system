<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|'
        ]);

        if(Auth::guard('admin')->attempt(['email'=>$request->email, 'password' => $request->password])){

            if(Auth::guard('admin')->user()->role != 'admin'){
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error','Unautherise user. Acess denied');    
            }else{
                return redirect()->route('admin.dashboard')->with('success','User logged in successfully.');
            }
            
        }else{
            return redirect()->route('admin.login')->with('error','somthing went wrong.');
        }

        
    }

    public  function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logout successfully.');
    }

    public function register(){
        $user = new User();
        $user->name = "Salim Shaikh";
        $user->email = "salimsheikh4u2000@gmail.com";
        $user->role = "student";
        $user->password = Hash::make("1");
        $user->save();
        return redirect()->route('admin.login')->with('success','User created successfully.');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function form(){
        return view('admin.form');
    }

    public function table(){
        return view('admin.table');
    }

    
}
