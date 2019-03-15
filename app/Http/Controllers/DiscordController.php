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

    private $access_token;

    /**
     * Redirects the user to the Discord server.
     */
    public function redirectToServer($channel = null)
    {
        // If there is no Discord access token...
        if (! $this->getAccessToken()) {
            // Store the channel in the session...
            session(['discord_channel_id' => $channel]);

            // Redirect for authentication...
            return $this->authenticate();
        }

        // else...

        $user = Socialite::driver('discord')->userFromToken($this->getAccessToken());
        $discord = new DiscordClient(['token' => config('discord.clients.guildbot.token')]);

        try {
            $discord->guild->addGuildMember([
                'guild.id' => self::GUILD_ID,
                'user.id' => intval($user->id),
                'access_token' => $user->token,
            ]);
        }
        catch (CommandException $e) {
            //
        }

        return redirect(self::URL.$channel);
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
            }

            return $this->redirectToServer(session('discord_channel_id'));
        }
        catch (ClientException $e) {
            return $this->authenticate();
        }
        catch (InvalidStateException $e) {
            return abort(500);
        }
    }
}
