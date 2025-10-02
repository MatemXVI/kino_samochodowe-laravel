@extends('app')

@section('title', "Kup bilet")

@section('content')
    <h2>Wybierz sposób płatności</h2>
    <form action="{{ route("ticket.summary") }}" method="post">
        @csrf
        <table align="center" id="platnosc">
            <tr><td><label><input type="radio" name="payment" value="Karta płatnicza" required>Karta płatnicza</label><img src={{ Storage::url("img/ticket/visa_mastercard.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="payment" value="Google Pay">Google Pay</label><img src={{ Storage::url("img/ticket/google_pay.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="payment" value="BLIK">BLIK</label><img src={{ Storage::url("img/ticket/blik.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="payment" value="Przelew online">Przelew online</label><img src={{ Storage::url("img/ticket/payu.png") }} height="34"></td></tr>
            <tr><td><label><input type="radio" name="payment" value="Paypal">Paypal</label><img src={{ Storage::url("img/ticket/paypal.png") }} height="34"></td></tr>
        </table>
        <input type="hidden" name="parking_spot_number" value= {{ $parkingSpotNumber }}  >
        <input type="hidden" name="screening_id" value={{ $screeningId }}  >
        <input type="submit" value="Wybierz płatność">
    </form><br>
     @foreach ($errors->all() as $error)
        <span class="error">{{ $error }}</span>
    @endforeach


@endsection
