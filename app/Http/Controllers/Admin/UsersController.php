<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(){
        $limit = 5;
        if (Auth::user()->role === 'superadmin') {
            $paginator = User::orderBy("role")->paginate($limit);
        }else{
            $paginator = User::where("role", "user")->paginate($limit);
        }
        return view("admin.users.index", compact("paginator"));
    }

    public function edit(User $user){
        if(Auth::user()->role != "superadmin" && ($user->role == "admin" || $user->role == "superadmin" )){
            return redirect(route("admin.users.index"));
        }
        return view("admin.users.edit", compact("user"));
    }

    public function create(){
        return view("admin.users.register_admin");
    }

    public function store(Request $request){
        $data = $request->validate([
            'email' => ['required', 'email:filter', 'unique:users,email'],
            'login' => ['required', 'between:3,20', 'alpha_dash', 'unique:users,login'],
            'password' => ['required', 'between:5,20', 'confirmed'],
            'name' => ['nullable', 'regex:/\S+\s+\S+/'],
            'age' => ['nullable', 'gte:1', 'lte:150'],
            'phone_number' => ['nullable', 'regex:/^(?:\d{9}|\d{3}\s\d{3}\s\d{3})$/'],
        ],
        [
            "email.unique" => "Istnieje już konto z tym e-mailem!",
            "email.*" => "E-mail jest niepoprawny!",
            "name.required" => "Brak imienia i nazwiska!",
            "name.regex" => "Niepoprawny format imienia i nazwiska!",
            "login.*" => "Login musi posiadać od 3 do 20 znaków!",
            "login.unique" => "Konto już istnieje!",
            "password.between" => "Hasło musi się składać z 5 do 20 znaków!",
            "password.confirmed" => "Hasła się nie zgadzają!",
            "age.*" => "Wiek jest niepoprawny!",
            "phone_number.*" => "Numer telefonu jest niepoprawny!",
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'admin';
        User::create($data);
        $request->session()->regenerate();
        return redirect(route("admin.users.index"))->with('message', "Administrator został zarejestrowany.");

    }

    public function update(Request $request, User $user){
        $data = $request->validate([
            'email' => ['sometimes','required','email:filter', Rule::unique('users')->ignore($user->id)],
            'login' => ['sometimes','required','min:3','max:20','alpha_dash', Rule::unique('users','login')->ignore($user->id)],
            'name' => ['sometimes','required','regex:/\S+\s+\S+/'],
            'age' => ['sometimes','required','gte:1','lte:150'],
            'phone_number' => ['sometimes','nullable','regex:/^(?:\d{9}|\d{3}\s\d{3}\s\d{3})$/'],
            'role' => ['sometimes','required', Rule::in(['admin','superadmin'])],
        ],
        [
            "email.unique" => "Istnieje już konto z tym e-mailem!",
            "email.*" => "E-mail jest niepoprawny!",
            "name.required" => "Brak imienia i nazwiska!",
            "name.regex" => "Niepoprawny format imienia i nazwiska!",
            "login.*" => "Login musi posiadać od 3 do 20 znaków!",
            "login.unique" => "Konto już istnieje!",
            "password.between" => "Hasło musi się składać z 5 do 20 znaków!",
            "password.confirmed" => "Hasła się nie zgadzają!",
            "age.*" => "Wiek jest niepoprawny!",
            "phone_number.*" => "Numer telefonu jest niepoprawny!",
        ]);

        if (!$request->hasAny(['email','login','name','age','phone_number','role'])) {
            return back()->with('message', 'Nie wybrano żadnych pól do edycji.');
        }

        $user->fill($data);

        if (!$user->isDirty()){
            return redirect()->back()->with('message', 'Nie wprowadzono żadnych zmian.');
        }

        $user->save();
        return redirect()->route('admin.users.index')->with('message', 'Dane użytkownika zostały zmienione.');

    }

    public function edit_password(User $user){
        return view("admin.users.edit_password", compact("user"));
    }

    public function update_password(User $user, Request $request){
        $data = $request->validate(['password' => ['required', 'min:5', 'max:20', 'confirmed']]);
        $user->password = Hash::make($data['password']);
        $user->save();
        return redirect()->route('admin.users.index')->with('message', 'Hasło zostało zmienione.');
    }

    public function destroy(User $user){ //bardzo ambitne byłoby miękkie usunięcie na krótki czas a potem trwałe usunięcie na długo, ale to w przyszłości
        $user->delete();
        return redirect()->route("admin.users.index")->with('message', ("Użytkownik został usunięty z bazy."));
    }
}
