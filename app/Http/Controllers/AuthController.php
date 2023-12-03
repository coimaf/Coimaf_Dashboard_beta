<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // public function currentUser()
    // {
    //     // Controlla se l'utente è autenticato
    //     if (auth()->check()) {
    //         // Ottieni l'utente autenticato
    //         $user = auth()->user();

    //         // Passa il nome dell'utente al componente
    //         return view('layouts.layoutDash', ['userName' => $user->name]);
    //     }

    //     // L'utente non è autenticato, fai qualcosa (reindirizzamento, messaggio, ecc.)
    //     return redirect('/login');
    // }
}
