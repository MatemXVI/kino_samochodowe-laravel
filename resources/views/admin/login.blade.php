@extends('app')

@section('title', "Logowanie administratora")

@section('content')

    <h1>Zaloguj się</h1>
    <div class="formularz">
        <h4>Panel administratora</h4>
        <form method="POST">
            @csrf
            <div class="pole_formularza"><label>Email:<br><input type="text" name="email" required></label></div>
            <div class="pole_formularza"><label>Hasło:<br><input type="password" name="password" required></label></div>
            <div class="przycisk_formularz"><input type="submit" name="logowanie" value="Zaloguj się"></div>
        </form>
    </div>

    @if(session('message'))
        <span><b>{{ session('message') }}</b></span>
    @endif
    @foreach ($errors->all() as $error)
        <span><b>{{ $error }}</b></span>
    @endforeach

@endsection

