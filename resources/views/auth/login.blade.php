@extends('app')

@section('title', "Logowanie")


@section('content')

    <div class = "formularz">
        <h1>Zaloguj się</h1>
        <form action="{{ route("login") }}" method="POST" id="logowanie">
            @csrf
            <div class="pole_formularza"><label>E-mail:<br><input type="email" id="email" name="email" value="{{ old('email') }}"></label></div>
            <div class="pole_formularza"><label>Hasło:<br><input type="password" id="haslo" name="password" ></label></div>
            <div class="przycisk_formularz"><input type="submit" id ="przycisk_formularz" name="logowanie" value="Zaloguj się"></div>
        </form>
    </div>
    @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach
    @if (session('message'))
        <span class="error">{{ session('message') }}</span>
    @endif
@endsection

