<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $users = User::all();
        return view('dashboard.profile', ['users' => $users]);
    }
}
