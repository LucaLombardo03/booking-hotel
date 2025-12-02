<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// Importiamo la Request personalizzata
use App\Http\Requests\DashboardUpdateRequest;

class HotelController extends Controller
{
    // --- PARTE PUBBLICA ---

    public function index(Request $request)
    {
        $query = Hotel::query();

        // Filtro Ricerca
        if ($request->has('search') && $request->search != '') {
            $s = $request->get('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                    ->orWhere('city', 'LIKE', "%{$s}%");
            });
        }

        // Ordinamento
        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }

        $hotels = $query->with('images')->paginate(6);
        return view('welcome', compact('hotels'));
    }

    public function show($id)
    {
        $hotel = Hotel::with('images')->findOrFail($id);

        // Date occupate (per calendario)
        $bookedDates = Reservation::where('hotel_id', $id)
            ->where('check_out', '>=', now())
            ->orderBy('check_in')
            ->get();

        return view('hotel_detail', compact('hotel', 'bookedDates'));
    }

    // --- DASHBOARD UTENTE ---

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $allReservations = Reservation::where('user_id', $user->id)
            ->with('hotel')
            ->orderBy('check_in', 'asc')
            ->get();

        $activeReservations = $allReservations->where('check_out', '>=', now()->startOfDay());
        $pastReservations = $allReservations->where('check_out', '<', now()->startOfDay())->sortByDesc('check_in');

        return view('dashboard', compact('activeReservations', 'pastReservations'));
    }

    // NOTA: Qui usiamo DashboardUpdateRequest invece di Request
    public function updateProfile(DashboardUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // La validazione è già stata fatta automaticamente dalla classe DashboardUpdateRequest.
        // Possiamo procedere direttamente al salvataggio.

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profilo aggiornato con successo!');
    }

    public function destroyProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Il tuo account è stato eliminato.');
    }
}
