<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    // Metoda za prikaz forme za registraciju
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Metoda za obradu registracije korisnika
    public function register(Request $request)
    {
        // Validacija podataka
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'health_id' => 'required|string|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Kreiranje korisnika
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'health_id' => $request->health_id,
        ]);

        return redirect()->route('login')->with('success', 'Registracija uspješna! Možete se prijaviti.');
    }
}
