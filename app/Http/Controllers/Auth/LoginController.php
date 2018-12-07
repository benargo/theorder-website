<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use SocialiteProviders\Manager\Config;
use Laravel\Socialite\Facades\Socialite;

/**
 * Login Controller
 *
 * This controller handles authenticating users for the application and
 * redirecting them to your home screen. The controller uses a trait
 * to conveniently provide its functionality to your applications.
 */
class LoginController extends Controller
{
    /**
     * Contains the socialite driver instance.
     *
     * @var Illuminate\Support\Manager
     */
    protected $driver;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Configure the Socialite driver to use the EU region.
        $client_id = config('services.battlenet.client_id');
        $client_secret = config('services.battlenet.client_secret');
        $redirect = config('services.battlenet.redirect');
        $additional_config = ['region' => config('battlenet.region')];
        $config = new Config($client_id, $client_secret, $redirect, $additional_config);
        $this->driver = Socialite::driver('battlenet')->setConfig($config);
    }

    /**
     * Redirect the user to the Battle.net authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return $this->driver
            ->scopes(['wow.profile'])
            ->redirect();
    }

    /**
     * Obtain the user information from Battle.net.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        // Fetch details about the user from Battle.net...
        $response = $this->driver->user();

        // Check the database for a user model, or create one if one doesn't
        // exist...
        $user = User::firstOrCreate(
            ['id' => $response->id],
            [
                'id' => $response->id,
                'battletag' => $response->nickname,
                'bnet_access_token' => $response->token,
            ]
        );

        // Update and save the access token in case it has changed...
        $user->fill([
            'battletag' => $response->nickname,
            'bnet_access_token' => $response->token,
            'bnet_access_token_expires' => Carbon::now()->addDays(30)
        ]);
        $user->save();

        // Login and "remember" the given user...
        Auth::login($user, true);

        // Return them to the home page...
        return redirect()->intended('/');
    }
}
