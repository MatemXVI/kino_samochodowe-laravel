<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use chillerlan\QRCode\QRCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(){
        $tickets = Ticket::where("user_id",Auth::id())->get();
        return view("user.tickets", compact("tickets"));
    }

    public function show(Ticket $ticket){
        if (is_null($ticket->user_id) || $ticket->user_id !== Auth::id()) {
            abort(403, 'Nie masz dostępu do tego biletu.');
        }
        $ticket->load(['screening.film', 'screening.venue', 'user']);
        $qrcode = (new QRCode)->render($ticket->dataQR());
        return view("ticket.show", compact("ticket", "qrcode"));
     }

    public function downloadPDF(Ticket $ticket){
        if (!Auth::check() || (Auth::id() !== $ticket->user_id)) {
            abort(403, 'Nie masz dostępu do tego biletu.');
        }
        $ticket->load(['screening.film', 'screening.venue', 'user']);
        $qrcode = (new QRCode)->render($ticket->dataQR());
        $pdf = PDF::loadView('ticket.pdf', compact('ticket', 'qrcode'));
        return $pdf->download('bilet-' . $ticket->id . '.pdf');
    }

    public function destroy(Ticket $ticket){
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        $ticket->update(['user_id' => null, 'created_at' => null]);
        $message = "Bilet został usunięty.<br>Środki zostaną zwrócone na konto w przeciągu 7 dni,<br>na dane które podałeś przy zakupie biletu.";
        return redirect()->route("user.tickets.index")->with("success", nl2br($message));
    }
}
