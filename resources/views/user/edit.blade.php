@extends('app')

@section('title', "Panel użytkownika")

@section('scripts')
    <script>
        function disable(checkbox, form) {
            if (document.getElementById(checkbox).checked == true) {
                document.getElementById(form).disabled = false
            } else {
                document.getElementById(form).disabled = true
            }
        }
    </script>
@endsection

@section('content')

    <h1> Wybierz dane do edycji</h1>
    <div class="formularz">
        <form action="{{ route("user.update") }}" method="post">
            @csrf
            @method("PATCH")
            <div class="pole_formularza_maly_odstep"><label>Adres e-mail:<br><input type="checkbox" id="chbx_email"
                        onclick="disable('chbx_email','email')"><input type="email" id="email" name="email"
                        value="{{ old("email", $user->email) }}" disabled /></label></div>
            <div class="pole_formularza_maly_odstep"><label>Login:<br><input type="checkbox" id="chbx_login"
                        onclick="disable('chbx_login','login')"><input type="text" id="login" name="login"
                        value="{{ old("login", $user->login) }}" disabled /></label></div>
            <div class="pole_formularza_maly_odstep"><label>Imię:<br><input type="checkbox" id="chbx_imie"
                        onclick="disable('chbx_imie','imie')"><input type="text" id="imie" name="name"
                        value="{{ old("name", $user->name) }}" disabled /></label></div>
            <div class="pole_formularza_maly_odstep"><label>Telefon:<br><input type="checkbox" id="chbx_tel"
                        onclick="disable('chbx_tel','tel')"><input type="text" id="tel" name="phone_number"
                        value="{{ old("phone_number", $user->phone_number) }}" disabled /></label></div>
            <div class="pole_formularza"><label>Wiek:<input type="checkbox" id="chbx_wiek"
                        onclick="disable('chbx_wiek','wiek')"><input type="number" id="wiek" name="age"
                        value="{{ old("age", $user->age) }}" disabled /></label></div>
            <div class="przycisk_formularz"><input type="submit" name="edycja" value="Zmień dane" /></div>
        </form>
    </div>
    @foreach ($errors->user->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach
    @if (session('message_user'))
        <span class="error">{{ session('message_user') }}</span>
    @endif
    @if (session('success_user'))
        <span class="success">{{ session('success_user') }}</span>
    @endif
    <hr>
    <h2>Zmień hasło</h2>
    <div class="formularz">
        <form action="{{ route("user.password") }}" method='post'>
            @csrf
            @method("PATCH")
            <div class="pole_formularza_maly_odstep"><label>Stare hasło:<br><input type="password" id="stare_haslo" name="password_old"
                        required /></label></div>
            <div class="pole_formularza_maly_odstep"><label>Nowe hasło:<br><input type="password" id="haslo" name="password"
                        required /></label></div>
            <div class="pole_formularza_maly_odstep"><label>Powtórz hasło:<br><input type="password" id="powt_haslo"
                        name="password_confirmation" required /></label></div>
            <div class="przycisk_formularz"><input type="submit" name="edycja" value="Zmień hasło" /></div>
        </form>
    </div>
    <span class="error">
        @foreach ($errors->password->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        @if (session('message_password'))
            <div class="alert alert-danger">{{ session('message_password') }}</div>
        @endif
    </span>
    <span class="success">
        @if (session('success_password'))
                <div class="alert alert-danger">{{ session('success_password') }}</div>
        @endif
    </span>
@endsection
