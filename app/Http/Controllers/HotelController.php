<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HotelController extends Controller
{
    // PUBBLICA
    public function index(Request $request)
    {
        $query = Hotel::query();
        if ($request->has('search')) {
            $s = $request->get('search');
            $query->where('name', 'LIKE', "%{$s}%")->orWhere('city', 'LIKE', "%{$s}%");
        }
        $hotels = $query->get();
        return view('welcome', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Recuperiamo le prenotazioni future per questo hotel
        $bookedDates = Reservation::where('hotel_id', $id)
            ->where('check_out', '>=', now()) // Solo prenotazioni future o in corso
            ->orderBy('check_in')
            ->get();

        return view('hotel_detail', compact('hotel', 'bookedDates'));
    }

    // UTENTE
    public function dashboard()
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('hotel')->orderBy('check_in', 'desc')->get();
        return view('dashboard', compact('reservations'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validazione
        $request->validate([
            'name' => 'required|string|max:255',
            // Controlla che l'email sia unica, MA ignora l'email dell'utente attuale (altrimenti da errore se non la cambi)
            'email' => 'required|email|unique:users,email,' . $user->id,
            // La password è "nullable" (puoi lasciarla vuota se non vuoi cambiarla)
            'password' => 'nullable|min:8|confirmed',
        ]);

        // 2. Aggiornamento Dati Base
        $user->name = $request->name;
        $user->email = $request->email;

        // 3. Aggiornamento Password (Solo se l'utente ha scritto qualcosa nel campo)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Salvataggio nel DB
        $user->save();

        return back()->with('success', 'Profilo aggiornato con successo!');
    }

    public function storeReservation(Request $request)
    {
        // 1. VALIDAZIONE CON MESSAGGI IN ITALIANO
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ], [
            'check_in.after' => 'Il check-in deve essere una data futura.',
            'check_out.after' => 'La data di check-out deve essere successiva al check-in.',
        ]);

        // 2. CONTROLLO SOVRAPPOSIZIONE (Già fatto prima, lascialo così)
        $exists = Reservation::where('hotel_id', $request->hotel_id)
            ->where(function ($query) use ($request) {
                $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Ci dispiace, queste date sono già occupate.']);
        }

        // 3. SALVATAGGIO
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out
        ]);

        return redirect()->route('dashboard')->with('success', 'Prenotazione confermata!');
    }

    // ADMIN
    public function adminHome()
    {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
    }

    public function adminUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function storeHotel(Request $request)
    {
        Hotel::create($request->all());
        return back();
    }

    public function deleteHotel($id)
    {
        Hotel::destroy($id);
        return back();
    }
}
