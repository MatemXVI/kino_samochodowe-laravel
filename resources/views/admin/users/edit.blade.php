@extends('app')

@section('title', "Panel administracyjny")

@section('scripts')

    <script>
        function disable(checkbox,form){
            if(document.getElementById(checkbox).checked == true){
                document.getElementById(form).disabled = false
            }else{
                document.getElementById(form).disabled = true
            }
        }
    </script>

@section('content')

<h1> Wybierz dane do edycji</h1>
<div class ="formularz">
    <form action='{{ route("admin.users.update", $user->id) }}' method='post'>
        @csrf
		@method("PATCH")
        <div class="pole_formularza_maly_odstep"><label>Adres e-mail:*<br><input type="checkbox" id="chbx_email" onclick="disable('chbx_email','email')"><input type="email" id="email" name="email" value="{{ $user->email }}"  disabled /></label></div>
        <div class="pole_formularza_maly_odstep"><label>Login:*<br><input type="checkbox" id="chbx_login" onclick="disable('chbx_login','login')"><input type="text" id="login" name="login" value="{{ $user->login }}" disabled /></label></div>
        <div class="pole_formularza_maly_odstep"><label>Imię i nazwisko:*<br><input type="checkbox" id="chbx_name" onclick="disable('chbx_name','name')"><input type="text" id="name" name="name" value="{{ $user->name }}" disabled /></label></div>
        <div class="pole_formularza"><label>Telefon:<br><input type="checkbox" id="chbx_phone_number" onclick="disable('chbx_phone_number','phone_number')"><input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" disabled /></label><br></div>
        <div class="pole_formularza_maly_odstep"><label><input type="checkbox" id="chbx_age" onclick="disable('chbx_age','age')">Wiek:* <input type="number" id="age" name="age" value="{{ $user->age }}" disabled /></label></div>
    @if($user->role == "admin" || $user->role == "superadmin")
        Rola:<input type="radio" id="admin" name="role" value="admin" {{  $user->role == 'admin' ? 'checked' : '' }} /> Admin </label><input type="radio" id="superadmin" name="role" value="superadmin" {{  $user->role == 'superadmin' ? 'checked' : '' }} /> Superadmin </label>
    @endif
    </div>
        <div class="przycisk_formularz"><input type="submit" name="edycja" value="Edytuj" /></div>
    </form>
</div>
    @if(session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach

@endsection
