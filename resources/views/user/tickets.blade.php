@extends('app')

@section('title', "Panel użytkownika")

@section('content')

        <h2>Bilety:</h2>
        <div id='bilety'>
        @if($tickets != null)
            @foreach($tickets as $ticket)
                {{-- @if($loop->first)
                    <div class='bilety_kolumna'> //kolumna za bardzo idzie na lewo
                @endif --}}
                <div class='numer_biletu'><b><a href={{ route("ticket.show",  $ticket->id )}}> {{ $ticket->id }}</a></b></div>
                {{-- @if($loop->iteration % 10 == 0)
                    </div>
                @endif --}}
                @if($loop->last && $loop->iteration % 10 != 0)
                </div><div style='clear:both'></div>
                @endif
            @endforeach
        @else
            <h3>Nie masz żadnych biletów!</h3>
        @endif
        </div>
     @if (session('message'))
        <span class="success">{{ session('message') }}</span>
    @endif


@endsection
