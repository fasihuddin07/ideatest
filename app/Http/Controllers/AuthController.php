<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AuthController extends Controller
{
    public function login(){
        // dd("checked");
        if(Auth::user()){
            return redirect('/');
        }else{
            return view('auth.login');
        }       
    }

    public function register(){
        // dd("checked");
        if(Auth::user()){
            return redirect('/');
        }else{
            return view('auth.register');
        }       
    }

    public function store(Request $request){
        // dd($request);
        $request->validate([
            'email' => ['required','string'],
            'password' => ['required','string']
         ]);


         $data = [
            'email' => $request->email,
            'password' => $request->password
         ];

         if(Auth::attempt($data)){
            return redirect('/');
         }else{
            return redirect("auth/login");
        }

       
    }

    public function registerstore(Request $request){
        // dd($request);
    
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('auth/logout');
       
    }

    public function logout(){
        Auth::logout();
        return redirect('auth/login');
    }
}
