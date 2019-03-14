<?php

namespace App\Http\Controllers;

use RestCord\DiscordClient;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
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

    /**
     * Redirects the user to the Discord server.
     */
    public function redirectToServer($channel = null)
    {
        if (! session('discord_access_token')) {
            return Socialite::driver('discord')
                ->scopes(['guilds.join'])
                ->redirect();
        }

        $user = Socialite::driver('discord')->userFromToken(session('discord_access_token'));

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
     * Obtain the user information from Discord.
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('discord')->user();

        session(['discord_access_token' => $user->token]);

        return redirect()->action('DiscordController@redirectToServer');
    }
}
