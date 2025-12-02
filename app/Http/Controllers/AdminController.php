<?php

namespace App\Http\Controllers;

// 1. IMPORTIAMO I NUOVI FILE REQUEST
use App\Http\Requests\StoreHotelRequest;  // <--- NUOVO
use App\Http\Requests\UpdateHotelRequest; // <--- NUOVO
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $hotels = Hotel::withCount('reservations')->get();
        return view('admin.home', compact('hotels'));
    }

    // 2. MODIFICHIAMO QUESTO METODO
    // Nota: Ora usa "StoreHotelRequest" invece di "Request"
    public function storeHotel(StoreHotelRequest $request)
    {
        // NON serve più $request->validate([...]) qui!
        // Se il codice arriva a questa riga, i dati sono già validi.

        // Usiamo $request->validated() per prendere solo i dati puliti
        $hotel = Hotel::create($request->validated());

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

    // 3. MODIFICHIAMO ANCHE QUESTO
    // Nota: Ora usa "UpdateHotelRequest"
    public function updateHotel(UpdateHotelRequest $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        // Anche qui, via la validazione manuale.

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

    // --- GESTIONE UTENTI (Resta uguale) ---

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
