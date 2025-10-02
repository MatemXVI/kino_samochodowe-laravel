@extends('app')

@section('title', "Panel administracyjny")

@section('content')
    <h1>Zarejestruj się</h1>
    <div class="formularz">
        <form action="{{ route("admin.administrators.store") }}" method="post">
            @csrf
            <table align="center">
                <tr>
                    <td><label>Adres e-mail<sup>*</sup>:<br><input type="text" id="email" name="email" value="{{ old('email') }}"></label></td>
                    <td><label>Login<sup>*</sup>:<br><input type="text" id="login" name="login" value="{{ old('login') }}"></label></td>
                </tr><tr>
                    <td><label>Imię i nazwisko<sup></sup>:<br><input type="text" id="imie" name="name" value="{{ old('name') }}"></label></td>
                    <td><label>Hasło<sup>*</sup>:<br><input type="password" id="haslo" name="password"></label></td>
                </tr><tr>
                    <td><label>Wiek<sup></sup>:<br><input type="number" id="wiek" name="age" min="1" value="{{ old('age') }}"></label></td>
                    <td><label>Potwierdź hasło<sup>*</sup>:<br><input type="password" id="powt_haslo" name="password_confirmation"></label></td>
                </tr><tr>
                    <td><label>Telefon:<br><input type="text" id="telefon" name="phone_number" value="{{ old('phone_number') }}"></label></td></tr>
            </table>
            <div class="przycisk_formularz"><input type="submit" id="przycisk_formularz" name="register" value="Zarejestruj" /></div>
        </form>
    </div>
    @foreach ($errors->all() as $error)
        <span class="error"> {{ $error }}</span>
    @endforeach
    @if (session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
@endsection
