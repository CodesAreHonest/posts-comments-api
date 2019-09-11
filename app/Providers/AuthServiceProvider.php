<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Nomadnt\LumenPassport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // register passport routes
        Passport::routes();

        // change the default token expiration
        Passport::tokensExpireIn(Carbon::now()->addMinutes(60));

        // oauth service scopes
        Passport::tokensCan([
            'users' => 'Authenticated user. ',
            'admins' => 'Authenticated administrator. ',
        ]);

        // change the default refresh token expiration
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(75));
    }
}
