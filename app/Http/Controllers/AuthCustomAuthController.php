<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCustomAuthController extends Controller
{
    public function login(Request $request)
    {
        // Verifica che il nome utente e la password siano "root"
        if ($request->username === 'root' && $request->password === 'root') {
            // Autentica manualmente l'utente
            Auth::loginUsingId(1); // Assumi che l'ID dell'utente "root" sia 1
            return redirect()->intended('/dashboard'); // Reindirizza alla dashboard dopo il login
        }

        // Se le credenziali non corrispondono, reindirizza con un errore
        return redirect()->back()->withErrors(['credentials' => 'Le credenziali non sono valide']);
    }
}
