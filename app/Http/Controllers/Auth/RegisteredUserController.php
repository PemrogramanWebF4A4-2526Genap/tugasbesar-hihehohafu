<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:buyer,seller'], // Validasi pilihan peran akun
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Menyimpan string role 'buyer' atau 'seller' ke DB
            'balance' => $request->role === 'buyer' ? 500000.00 : 0.00, // Saldo awal 500rb diberikan khusus pembeli
        ]);

        event(new Registered($user));

        Auth::login($user);

        // PENGALIHAN ALUR DAFTAR OTOMATIS Pak
        // Jika mendaftar sebagai penjual, langsung lempar ke dashboard seller
        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        // Jika pembeli, lempar ke dashboard pembeli bawaan
        return redirect()->route('dashboard');
    }
}