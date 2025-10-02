@extends('app')

@section('title', "Bilet")

@section('content')

    <div id ="bilet">
        <div id="left-side">
            <div id="logo"><b>KINO SAMOCHODOWE</b></div>
        </div>
        <div id="main-side">
            <div id="main-information">
                <div id="id-biletu">
                    Numer biletu: #{{ $ticket->id }}<br>
                    Wygenerowano: {{ $ticket->created_at }}<br>
                </div>
                <div id="screening-information">
                    <h1>{{ $ticket->screening->name }}</h1>
                </div>
                <div id="rest-information">
                    {{-- <div id="name"><b>{{ $ticket->screening->name }}</b></div> --}}
                    Data seansu:
                    <b>{{ $ticket->screening->date." ".$ticket->screening->hour }}</b><br>
                    Numer miejsca parkingowego: <b>{{ $ticket->parking_spot_number }}</b><br>
                    Miejsce: <b>{{ $ticket->screening->venue->city }} ul.{{ $ticket->screening->venue->street }}</b><br>
                </div>
                <div id="announcement">
                    <i>Częstotliwość stacji radiowej zostanie udostępniona przed seansem. W razie problemów technicznych proszę wezwać pomoc!</i>
                </div>
                <div id="price">
                    <b>Cena: {{ $ticket->screening->price }} zł</b>
                </div>
            </div>
        </div>
        <div id="top-right-side">
            <img src = {{ Storage::url("img/ticket/car.png") }} height="200" width="400">
        </div>
        <div id="bottom-right-side">
            <img src="{{ $qrcode }}" height="250" width="250">
        </div>
    </div>
    <div style="clear:both"></div><br>
    @if(Auth::user()-> role == 'user')
    <form action="{{ route('user.tickets.destroy', $ticket->id) }}" method="POST" style="display:inline">
    @csrf @method('DELETE')
    <button type="submit" class="przycisk" onclick="return confirm('Czy na pewno chcesz usunąć bilet?')"><b>USUŃ BILET</b></button><br>
    </form>
    @endif
    @if (session('message'))
        <span class="success">{{ session('message') }}</span>
    @endif
@endsection
