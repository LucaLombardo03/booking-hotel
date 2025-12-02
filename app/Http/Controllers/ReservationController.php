<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest; // <--- NUOVO IMPORT
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // Nota: Ora usa "StoreReservationRequest"
    public function store(StoreReservationRequest $request)
    {
        // 1. VIA LA VALIDAZIONE MANUALE (è nel file Request ora)

        $hotel = Hotel::findOrFail($request->hotel_id);

        // 2. Controllo Disponibilità
        $overlappingCount = Reservation::where('hotel_id', $hotel->id)
            ->where(function ($query) use ($request) {
                $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->count();

        if ($overlappingCount >= $hotel->total_rooms) {
            return back()->withErrors(['error' => "Siamo spiacenti, l'hotel è al completo per queste date."]);
        }

        // 3. Calcolo Prezzo
        $start = Carbon::parse($request->check_in);
        $end = Carbon::parse($request->check_out);
        $days = $start->diffInDays($end);

        $tax = $hotel->tourist_tax ?? 0;
        $totalPrice = ($hotel->price * $days) + ($tax * $days);

        // 4. Creazione prenotazione
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice
        ]);

        return redirect()->route('dashboard')->with('success', 'Prenotazione confermata! Totale: € ' . number_format($totalPrice, 2));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $hoursUntilCheckIn = now()->diffInHours($reservation->check_in, false);

        if ($hoursUntilCheckIn < 24) {
            return back()->withErrors(['error' => 'Troppo tardi! Puoi cancellare solo fino a 24 ore prima del check-in.']);
        }

        $reservation->delete();
        return back()->with('success', 'Prenotazione cancellata correttamente.');
    }
}
