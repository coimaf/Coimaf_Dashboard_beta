<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function test()
    {
        $users = User::all();
        
        return view('test', compact('users'));
    }
}
