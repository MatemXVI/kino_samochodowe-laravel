<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Ticket;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Auth;

class BuyTicketController extends Controller
{
    public function parking(Request $request){
        $screeningId = $request->query(("screening_id"));
        $screening = Screening::with(["film", "venue"])->where("id", $screeningId)->firstOrFail();
        $availableParkingSpotCount = Ticket::whereNull("user_id")->where("screening_id", $screeningId)->count("*"); //ilość miejsc wolnych
        $parkingSpotCount = Ticket::where("screening_id", $screeningId)->count("*"); //$ilosc_miejsc
        $parkingSpots = Ticket::where("screening_id", $screeningId)->get(); //miejsca parkingowe
        return view("buy_ticket.parking", compact("screening", "availableParkingSpotCount", "parkingSpotCount", "parkingSpots"));
    }

    public function selected(Request $request){
        $parkingSpotNumber = $request->input("parking_spot_number");
        $screeningId = $request->input("screening_id");
        if($parkingSpotNumber && $screeningId){
            $ticket= Ticket::with(["screening.film", "screening.venue"])->where("parking_spot_number", $parkingSpotNumber)->where("screening_id", $screeningId)->whereNull("user_id")->firstOrFail();
            // session()->put("bilet", $ticket);
            return view("buy_ticket.selected", compact("ticket", "parkingSpotNumber", "screeningId"));
        }else{
            return redirect()->route('tickets.parking');
        }
    }

    public function payment(Request $request){
        $parkingSpotNumber = $request->input("parking_spot_number");
        $screeningId = $request->input("screening_id");
        return view("buy_ticket.payment", compact( "parkingSpotNumber", "screeningId"));
    }

    public function summary(Request $request){
        $parkingSpotNumber = $request->input("parking_spot_number");
        $screeningId = $request->input("screening_id");
        $payment = $request->validate(['payment' => ['required']]);
        $payment = $payment['payment'];
        $user = Auth::user();
        $ticket= Ticket::with(["screening.film", "screening.venue"])->where("parking_spot_number", $parkingSpotNumber)->where("screening_id", $screeningId)->whereNull("user_id")->firstOrFail();
        return view("buy_ticket.summary", compact( "ticket", "parkingSpotNumber", "screeningId", "payment", "user"));
    }

    public function generate(Request $request){
        if(!Auth::user())
            return redirect()->route("login")->with("message", "Musisz się zalogować, aby móc kupić bilet.");
        $parkingSpotNumber = $request->input("parking_spot_number");
        $screeningId = $request->input("screening_id");
        $ticket = Ticket::with(["screening.film", "screening.venue"])->where("parking_spot_number", $parkingSpotNumber)->where("screening_id", $screeningId)->whereNull("user_id")->firstOrFail();
        $ticket->user_id = Auth::user()->id;
        $ticket->created_at = now();
        $ticket->save();
        return redirect()->route("ticket.show", $ticket->id)->with("message","Bilet został zakupiony. Pamiętaj, że tylko z nim możesz wejść na seans. Zeskanuj kod QR przy wjeździe na parking. Życzymy miłego oglądania");
    }

}
