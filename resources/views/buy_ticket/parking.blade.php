@extends('app')

@section('title', "Kup bilet")

@section('content')

    <div id='seans_info'>
        <p><b>Seans: </b> {{ $screening->name }} <br><b> Data: </b>{{ $screening->date }} {{ $screening->hour }} <br><b> Film: </b>{{ $screening->film->title }} <br><b> Miejsce seansu: </b>{{ $screening->venue->city }}, {{ $screening->venue->street }} <br><b> Rodzaj miejsca:</b> {{ $screening->venue->place_type }} <br><b> Maksymalna ilość miejsc na seans wynosi: </b>{{ $parkingSpotCount }} </p>
        @if($availableParkingSpotCount == 0)
            <p><span style='color:red'><b>Brak miejsc na seans!</b></span></p>
        @elseif($availableParkingSpotCount < 10)
            <p><span style='color:red'><b>Zostało kilka miejsc parkingowych!</b></span></p>
        @else
            <p>Zostało {{ $availableParkingSpotCount }} miejsc parkingowych.</p>
        @endif
    </div>
    <table align='center' id='parking'>
        @foreach($parkingSpots as $parkingSpot)
            @if($loop->first)
                <tr><td class='rzad'>{{ $loop->first }}</td>
            @endif
            @if($parkingSpot->user_id == NULL)
                <td style="background-color:green">
                    <a href={{ route("ticket.selected", ['screening_id' => $screening->id, 'parking_spot_number' => $loop->iteration]) }}><b>{{ $loop->iteration}}</b></a>
                </td>
            @else
            <td style='background-color:red'><b>{{ $loop->iteration}}</b></td>
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

@endsection
