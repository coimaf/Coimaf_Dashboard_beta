<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticatesWithLdap;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'groups'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function boot()
    {
        parent::boot();
    
        static::saving(function ($user) {
            // Verifica se groups è un array
            if (is_array($user->groups)) {
                // Converti l'array in una stringa separata da virgola
                $user->groups = implode(' - ', $user->groups);
            } elseif (is_string($user->groups)) {
                // Utilizza una regex per estrarre solo il contenuto tra CN= e la virgola
                preg_match_all('/CN=(.*?),/', $user->groups, $matches);
    
                // Aggiorna $user->groups con il contenuto estratto
                $user->groups = implode(' - ', $matches[1]);
            }
        });
    }
    

}
