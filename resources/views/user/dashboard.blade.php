@extends('app')

@section('title', "Panel użytkownika")

@section('content')
    <h2>{{ Auth::user()->login }}</h2>
    <div id="user">
        <div class="ustawienia_user">
            <b><a href={{ route("user.tickets.index") }}>Bilety</a></b>
        </div>
        <div class="ustawienia_user">
            <b><a href={{ route("user.edit") }}>Zmień dane</a></b>
        </div>
    </div>
    @if (session('message'))
        <span class="information">{!! session('message') !!}</span>
    @endif

@endsection
