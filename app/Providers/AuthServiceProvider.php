<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
    * The model to policy mappings for the application.
    *
    * @var array<class-string, class-string>
    */
    protected $policies = [
        //
    ];
    
    /**
    * Register any authentication / authorization services.
    */
    public function boot(): void
    {
        Fortify::authenticateUsing(function ($request) {
            $validated = Auth::validate([
                'samaccountname' => $request->username,
                'password' => $request->password
            ]);
            
            return $validated ? Auth::getLastAttempted() : null;
        }); 
        
        $this->registerPolicies();
        
        Gate::define('dipendenti', function ($user) {
            // Logica per verificare se l'utente ha il permesso 'dipendenti'
            return $user->hasRole('dipendenti');
        });
    }
}
