<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    //strona główna użytkownika(Bilety, Edytuj dane)
    public function dashboard(){
        return view('user.dashboard');
    }


    //LOGOWANIE
    public function showLoginForm(){
        return view("auth.login");
    }

    public function login(Request $request){
        $credentials = $request->validate([
            "email" => ['required'],
            "password" => ['required']
        ], ["email" => "Brak loginu!", "password" => "Brak hasła!"]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect("/");
        }else{
            return back()->with('message', 'Nieprawidłowy login lub hasło.');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }


    //REJESTRACJA
    public function create(){
        return view("auth.register");
    }

    //logika rejestracji użytkownika
    public function store(Request $request){
        $data = $request->validate([
            'email' => ['required', 'email:filter', 'unique:users,email'],
            'login' => ['required', 'min:3', 'max:20', 'alpha_dash', 'unique:users,login'],
            'password' => ['required', 'min:5', 'max:255',  'confirmed'],
            'name' => ['required', 'regex:/\S+\s+\S+/'],
            'age' => ['required', 'gte:1', 'lte:150'],
            'phone_number' => ['nullable', 'regex:/^(?:\d{9}|\d{3}\s\d{3}\s\d{3})$/'],
            'terms' => ['accepted']
        ],
        [
            "email.unique" => "Istnieje już konto z tym e-mailem!",
            "email.*" => "E-mail jest niepoprawny!",
            "name.required" => "Brak imienia i nazwiska!",
            "name.regex" => "Niepoprawny format imienia i nazwiska!",
            "login.*" => "Login musi posiadać od 3 do 20 znaków!",
            "login.unique" => "Konto już istnieje!",
            "password.required" => "Hasło jest wymagane!",
            "password.between" => "Hasło musi mieć minimum 5 znaków!",
            "password.confirmed" => "Hasła się nie zgadzają!",
            "age.*" => "Wiek jest niepoprawny!",
            "phone_number.*" => "Numer telefonu jest niepoprawny!",
            "terms" => "Zaakceptuj regulamin!"
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect("/");

    }

    //formularz edycji użytkownika i hasła
    public function edit(){
        $user = Auth::user();
        return view("user.edit", compact("user"));
    }

    //edycja użytkownika
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validateWithBag("user",[
            'email' => ['sometimes','required','email:filter', Rule::unique('users')->ignore($user->id)],
            'login' => ['sometimes','required','min:3','max:255','alpha_dash', Rule::unique('users','login')->ignore($user->id)],
            'name' => ['sometimes', 'required', 'regex:/\S+\s+\S+/'],
            'phone_number' => ['nullable', 'regex:/^(?:\d{9}|\d{3}\s\d{3}\s\d{3})$/'],
            'age' => ['sometimes', 'required', 'gte:1', 'lte:150'],
        ],
        [
            "email.unique" => "Istnieje już konto z tym e-mailem!",
            "email.*" => "E-mail jest niepoprawny!",
            "name.required" => "Brak imienia i nazwiska!",
            "name.regex" => "Niepoprawny format imienia i nazwiska!",
            "login.*" => "Login musi posiadać od 3 do 20 znaków!",
            "login.unique" => "Konto już istnieje!",
            "name" => "Brak imienia i nazwiska!",
            "age.*" => "Wiek jest niepoprawny!",
            "phone_number.*" => "Numer telefonu jest niepoprawny!",
            "terms" => "Zaakceptuj regulamin!"
        ]);

        if (!$request->hasAny(['email','login','name','phone_number','age'])) {
            return back()->with('message_user', 'Nie wybrano żadnych pól do edycji.');
        }

        $user->fill($data);

        if (!$user->isDirty()) {
            return back()->with('message_user', 'Nie wprowadzono żadnych zmian.');
        }
        $user->save();
        return back()->with('success_user', 'Dane użytkownika zostały zmienione.');
    }
    //edycja hasła
    public function updatePassword(Request $request){
        $user = Auth::user();
        $password = $request["password_old"];
        if(Hash::check($password, $user->password)){
            $data = $request->validateWithBag("password",['password' => ['required', 'min:5', 'max:255', 'confirmed']],
                        ["password.min" => "Hasło musi mieć minimum 5 znaków!","password.confirmed" => "Hasła się nie zgadzają!"]);
            if(Hash::check($data["password"], $user->password)){
                return back()->with('message_password', 'Nowe hasło nie może być takie samo jak poprzednie!');
            }
            $user->password = Hash::make($data['password']);
            $user->save();
            return back()->with('success_password', 'Hasło zostało zmienione.');
        }else{
            return back()->with('message_password', 'Stare hasło użytkownika jest niepoprawne!');
        }
    }

}


