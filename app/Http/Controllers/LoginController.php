<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        // Per l'utente persistente
        $persistentUser = new PersistentUser();
        $credentials = [
            'username' => 'root',
            'password' => 'Supersecret1!',
        ];
        
        if ($persistentUser->attempt($credentials)) {
            echo('autenticato');
        }
        
    }
}
