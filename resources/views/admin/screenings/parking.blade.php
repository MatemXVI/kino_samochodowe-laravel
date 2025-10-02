@extends('app')

@section('title', "Panel administracyjny")

@section('content')

    <div id='seans_info'>
        <p><b>Seans: </b> {{ $screening->name }} <br><b> Data: </b>{{ $screening->date }} {{ $screening->hour }} <br><b> Film: </b>{{ $screening->film->title }} <br><b> Miejsce seansu: </b>{{ $screening->venue->city }}, {{ $screening->venue->street }} <br><b> Rodzaj miejsca:</b> {{ $screening->venue->place_type }} <br><b> Maksymalna ilość miejsc na seans wynosi: </b>{{ $ilosc_miejsc }} </p>
        @if($ilosc_miejsc_wolnych == 0)
            <p><span style='color:red'><b>Brak miejsc na seans!</b></span></p>
        @elseif($ilosc_miejsc_wolnych < 10)
            <p><span style='color:red'><b>Zostało kilka miejsc parkingowych!</b></span></p>
        @else
            <p>Zostało {{ $ilosc_miejsc_wolnych }} miejsc parkingowych.</p>
        @endif
    </div>
    <table align='center' id='parking'>
        @foreach($tickets as $ticket)
            @if($loop->first)
                <tr><td class='rzad'>{{ $loop->first }}</td>
            @endif
            @if($ticket->user_id == NULL)
                <td style="background-color:green">
                    <b>{{ $loop->iteration}}</b></td>
            @else
            <td style='background-color:red'><a href={{ route("ticket.show", $ticket->id) }} title='Nr biletu: {{ $ticket->id }}'><b>{{ $loop->iteration }}</b></a></td>
            @endif
            @if ($loop->iteration % 10 == 0)
                <td class='rzad'>{{ ceil($loop->iteration/10) }}</td></tr>
                @if(!$loop->last)
                        <tr><td class='rzad'>{{ ceil($loop->iteration/10) + 1 }}</td>
                @endif
            @endif
                @if($loop->last && $loop->count % 10 != 0)
                    @while($loop->count % 10!=0)
                        <td class='puste'></td>
                        <?php $loop->count++ ?>
                    @endwhile
                        <td class='rzad'>{{ ceil($loop->iteration/10) }}</td></tr>
                @endif
        @endforeach
	</table>
        @if(session('message'))
            <span><b>{{ session('message') }}</b></span>
        @endif

@endsection
