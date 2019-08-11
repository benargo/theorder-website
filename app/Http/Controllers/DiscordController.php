<?php

namespace App\Http\Controllers;

use RestCord\DiscordClient;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Two\InvalidStateException;
use GuzzleHttp\Command\Exception\CommandException;

/**
 * Discord Controller
 *
 * This controller sends the user to the Discord server. It requires them to
 * first authenticate with Discord.
 */
class DiscordController extends Controller
{
    const URL = 'https://discordapp.com/channels/470564810929733643/';
    const GUILD_ID = 470564810929733643;

    protected $access_token;
    protected $client;

    public function __construct()
    {
        $this->client = new DiscordClient(['token' => config('discord.clients.guildbot.token')]);
    }

    /**
     * Redirects the user to the Discord server.
     */
    public function redirectToServer($channel = null)
    {
        // Store the channel in the session...
        session(['return_url' => self::URL.$channel]);

        // If there is no Discord access token, redirect for authentication...
        if (! $this->getAccessToken()) {
            return $this->authenticate();
        }

        // Otherwise redirect to the Discord server...
        return redirect(self::URL.$channel);
    }

    /**
     * Links the user's account but keep them on the website.
     */
    public function linkAccount()
    {
        session(['return_url' => url()->previous()]);

        // Redirect for authentication...
        return $this->authenticate();
    }

    /**
     * Check if there is an access token in the class or the session.
     *
     * @return string|false
     */
    protected function getAccessToken()
    {
        if ($this->access_token) {
            return $this->access_token;
        }
        elseif (session('discord_access_token')) {
            $this->access_token = session('discord_access_token');

            return $this->access_token;
        }

        return false;
    }

    /**
     * Set the access token to the class and the session.
     *
     * @param  string  $value
     * @return void
     */
    protected function setAccessToken($value)
    {
        $this->access_token = $value;
        session(['discord_access_token' => $value]);
    }

    /**
     * Redirect the user to be authenticated.
     */
    protected function authenticate()
    {
        return Socialite::driver('discord')
            ->scopes(['guilds.join'])
            ->redirect();
    }

    /**
     * Obtain the user information from Discord.
     */
    public function handleProviderCallback()
    {
        try {
            $discord_user = Socialite::driver('discord')->user();

            $this->setAccessToken($discord_user->token);

            if (Auth::check()) {
                // The user is logged in...

                $user = Auth::user();

                if (empty($user->discord_user_id)) {
                    $user->discord_user_id = $discord_user->id;
                    $user->save();
                }
                elseif ($user->discord_user_id !== $discord_user->id) {
                    // TODO: Redirect to page requesting the user to confirm overwriting their saved Discord user ID...
                }

                $this->client->guild->addGuildMember([
                    'guild.id' => self::GUILD_ID,
                    'user.id' => intval($discord_user->id),
                    'access_token' => $discord_user->token,
                ]);
            }
        }
        catch (ClientException $e) {
            return $this->authenticate();
        }
        catch (CommandException $e) {
            //
        }
        catch (InvalidStateException $e) {
            return abort(500);
        }

        return redirect(session('return_url', self::URL));
    }
}
