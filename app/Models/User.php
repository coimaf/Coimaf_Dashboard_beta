<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Ticket;
use App\Models\Deadline;
use App\Models\Employee;
use App\Models\MachinesSold;
use Laravel\Sanctum\HasApiTokens;
use LdapRecord\Query\Model\Builder;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use LdapRecord\Models\ActiveDirectory\Group as LdapGroup;


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
    
                // Modifica l'indirizzo email se termina con ".lan"
                $user->email = str_ends_with($user->email, '.lan') ? substr($user->email, 0, -3) . 'com' : $user->email;
            }
        });
    }
    

    public function employees() {
        return $this->hasMany(Employee::class, 'updated_by');
    }
    
    public function deadlines() {
        return $this->hasMany(Deadline::class, 'updated_by');
    }

    public function machinesSolds() {
        return $this->hasMany(MachinesSold::class, 'updated_by');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'updated_by');
    }

}
