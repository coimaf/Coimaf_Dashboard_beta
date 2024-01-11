<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Deadline;
use App\Models\Employee;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LdapRecord\Models\ActiveDirectory\Group as LdapGroup;
use LdapRecord\Query\Model\Builder;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;


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
        'groups' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
    
        static::saving(function ($user) {
            // Ottieni l'oggetto utente da Active Directory
            $ldapUser = LdapUser::find($user->distinguishedname);
    
            // Verifica se l'utente è presente in Active Directory
            if ($ldapUser) {
                // Ottieni i gruppi associati all'utente dal campo memberof
                $groupDNs = $ldapUser->memberof;
    
                // Estrai i nomi dei gruppi dai DN
                $groupNames = collect($groupDNs)->map(function ($groupDN) {
                    $matches = [];
                    // Estrai il nome del gruppo dal DN
                    preg_match('/CN=([^,]+)/', $groupDN, $matches);
                    return $matches[1] ?? null;
                })->filter()->toArray();
    
                // Formatta gli elementi come una stringa separata da "-"
                $formattedGroups = implode(' - ', $groupNames);
    
                // Assegna la stringa formattata all'attributo 'groups'
                $user->groups = $formattedGroups;
            }
        });
    }
    

    public function employees() {
        return $this->hasMany(Employee::class);
    }
    
    public function deadlines() {
        return $this->hasMany(Deadline::class);
    }

}
