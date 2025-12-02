<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // --- GESTIONE DASHBOARD & HOTEL ---

    public function index()
    {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'price' => 'required|numeric',
            'tourist_tax' => 'nullable|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $hotel = Hotel::create($request->all());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $filename);

                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'image_path' => 'uploads/' . $filename
                ]);
            }
        }

        return back()->with('success', 'Hotel aggiunto con successo!');
    }

    public function editHotel($id)
    {
        $hotel = Hotel::with('images')->findOrFail($id);
        return view('admin.edit', compact('hotel'));
    }

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'price' => 'required|numeric',
            'tourist_tax' => 'nullable|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $hotel->update($request->except('images'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $filename);

                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'image_path' => 'uploads/' . $filename
                ]);
            }
        }

        return redirect()->route('admin.home')->with('success', 'Hotel modificato con successo!');
    }

    public function destroyHotel($id)
    {
        Hotel::destroy($id);
        return back()->with('success', 'Hotel rimosso');
    }

    // --- GESTIONE UTENTI ---

    public function usersIndex()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utente aggiornato con successo!');
    }

    public function destroyUser($id)
    {
        if (Auth::id() == $id) {
            return back()->withErrors(['error' => 'Non puoi cancellare te stesso!']);
        }

        User::destroy($id);
        return back()->with('success', 'Utente eliminato.');
    }
}
