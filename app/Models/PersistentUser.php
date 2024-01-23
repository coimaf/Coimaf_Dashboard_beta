<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function deadlines() {
        return $this->hasMany(Deadline::class);
    }
}