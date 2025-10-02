<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
        return view("admin.index");
    }

    public function showLoginForm(){
        return view('admin.login');
    }

    public function login(Request $request){

        $credentials = $request->validate([
            "email" => ['required', 'email:filter'],
            "password" => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') {
                return redirect()->route("admin.index");
            }else{
                Auth::logout();
                abort(403, 'Brak dostępu.');
            }
        }else{
            return back()->with('message', 'Nieprawidłowy login lub hasło.');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('message', "Zostałeś wylogowany");
    }
}
