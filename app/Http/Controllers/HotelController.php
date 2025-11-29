<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    // PUBBLICA
    public function index(Request $request) {
        $query = Hotel::query();
        if ($request->has('search')) {
            $s = $request->get('search');
            $query->where('name', 'LIKE', "%{$s}%")->orWhere('city', 'LIKE', "%{$s}%");
        }
        $hotels = $query->get();
        return view('welcome', compact('hotels'));
    }

    public function show($id) {
        $hotel = Hotel::findOrFail($id);
        return view('hotel_detail', compact('hotel'));
    }

    // UTENTE
    public function dashboard() {
        $reservations = Reservation::where('user_id', Auth::id())->with('hotel')->orderBy('check_in', 'desc')->get();
        return view('dashboard', compact('reservations'));
    }

    public function storeReservation(Request $request) {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in'
        ]);
        Reservation::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out
        ]);
        return redirect()->route('dashboard');
    }

    // ADMIN
    public function adminHome() {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
    }

    public function adminUsers() {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function storeHotel(Request $request) {
        Hotel::create($request->all());
        return back();
    }

    public function deleteHotel($id) {
        Hotel::destroy($id);
        return back();
    }
}