<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use RestCord\DiscordClient;
use App\Discord\RolesRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use SocialiteProviders\Manager\OAuth2\User as DiscordUser;
use Illuminate\Contracts\Auth\Authenticatable;
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
    protected $roles;

    public function __construct(DiscordClient $client, RolesRepository $roles)
    {
        $this->client = $client;
        $this->roles  = $roles;
    }

    /**
     * Redirects the user to the Discord server.
     */
    public function main($channel = null)
    {
        // Store the channel in the session...
        session(['discord_redirect_url' => self::URL.$channel]);

        // If there is no Discord access token, redirect for authentication...
        if ($this->getAccessToken() === false) {
            return $this->authenticate();
        }

        // Add the user to the Discord guild and assign them the correct
        // rank...
        $discord_user = Socialite::driver('discord')->userFromToken($this->getAccessToken());
        $this->addUserToGuild($discord_user, Auth::user());

        // Otherwise redirect to the Discord server...
        return redirect(self::URL.$channel);
    }

    /**
     * Links the user's account but keep them on the website.
     */
    public function linkAccount()
    {
        session(['discord_redirect_url' => url()->previous()]);

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
     * @param  SocialiteProviders\Manager\OAuth2\User  $user
     * @return void
     */
    protected function setAccessToken(DiscordUser $user)
    {
        $this->access_token = $user->token;
        session(['discord_access_token' => $this->access_token]);
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
     * Add the user to the guild and assign the role.
     *
     * @param  SocialiteProviders\Manager\OAuth2\User     $discord_user
     * @param  Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    protected function addUserToGuild(DiscordUser $discord_user, Authenticatable $user = null)
    {
        try {
            $this->client->guild->addGuildMember([
                'guild.id'     => self::GUILD_ID,
                'user.id'      => intval($discord_user->id),
                'access_token' => $discord_user->token,
            ]);

            // Prune the user of roles that does not equivate to ranks...
            $ranks = $this->roles->getRanks();

            if ($user) {
                $ranks->reject(function ($role) use ($user) {
                    return ($role->name == $user->rank->title);
                })->each(function ($role) use ($discord_user) {
                    $this->client->guild->removeGuildMemberRoles([
                        'guild.id' => self::GUILD_ID,
                        'user.id'  => $discord_user->id,
                        'role.id'  => $role->id,
                    ]);
                });

                // Assign the user to their role...
                $this->client->guild->addGuildMemberRole([
                    'guild.id' => self::GUILD_ID,
                    'user.id'  => intval($discord_user->id),
                    'role.id'  => $this->roles->firstWhere('name', $user->rank->title),
                ]);
            }
        }
        catch (ClientException $e) {
            // Do nothing here, because if the user is already assigned to the
            // guild and has the correct role then we want the commands to fail
            // softly.
        }
        catch (CommandException $e) {
            // Do nothing here, because if the user is already assigned to the
            // guild and has the correct role then we want the commands to fail
            // softly.
        }
    }

    /**
     * Obtain the user information from Discord.
     */
    public function handleProviderCallback()
    {
        try {
            $discord_user = Socialite::driver('discord')->user();

            $this->setAccessToken($discord_user);

            if (Auth::check()) {
                $user = Auth::user();

                if (empty($user->discord_user_id)) {
                    $user->discord_user_id = $discord_user->id;
                    $user->save();
                }
                elseif ($user->discord_user_id !== $discord_user->id) {
                    // TODO: Redirect to page requesting the user to confirm overwriting their saved Discord user ID...
                }

                $this->addUserToGuild($discord_user, $user);
            }
            else {
                // Add the user to the Discord guild but without the user...
                $this->addUserToGuild($discord_user);
            }
        }
        catch (ClientException $e) {
            return $this->authenticate();
        }
        catch (CommandException $e) {
            // Do nothing here, because if the user is already assigned to the
            // guild and has the correct role then we want the commands to fail
            // softly.
        }
        catch (InvalidStateException $e) {
            return $this->authenticate();
        }

        return redirect(session('discord_redirect_url', self::URL));
    }
}
