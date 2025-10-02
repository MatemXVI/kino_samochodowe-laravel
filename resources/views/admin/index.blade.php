@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    <div id='menu'>
        <h1>Panel administracyjny</h1>
        <div><a href={{ route("admin.screenings.index") }}>Seanse</a></div>
        <div><a href={{ route("admin.films.index") }}>Filmy</a></div>
        <div><a href={{ route("admin.venues.index") }}>Miejsca</a></div>
        <div><a href={{ route("admin.users.index") }}>Użytkownicy</a></div>
    </div>
    @if(session('message'))
        <span><b>{{ session('message') }}</b></span>
    @endif

@endsection
