<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class PersistentUser extends Authenticatable implements AuthenticatableContract

{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
    ];

    public function attempt(array $credentials = [])
    {
        return $credentials['username'] === 'root' && $credentials['password'] === 'Supersecret1!';
    }
}