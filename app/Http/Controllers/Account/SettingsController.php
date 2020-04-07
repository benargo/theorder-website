<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\Models\User;
use RestCord\DiscordClient;
use Illuminate\Http\Request;
use App\Blizzard\Warcraft\Races;
use App\Blizzard\Warcraft\Classes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    /**
     * Renders the settings page for the user. This page requires several
     * services to be injected, so they are loaded here and then passed into
     * the view.
     *
     * @return Illuminate\Http\Response
     */
    public function settingsPage(Classes $classes, DiscordClient $discord, Races $races, Request $request)
    {
        $discord_tag  = null;
        $faction = config('blizzard.faction');
        $user = $request->user();

        if ($user->discord_user_id) {
            $discord_user = $discord->user->getUser(['user.id' => $user->discord_user_id]);
            $discord_tag = $discord_user->username . '#' . $discord_user->discriminator;
        }

        return view('account_settings', [
            'battletag' => $user->battletag,
            'classes'   => $classes->getClassicClasses($faction)->toJson(),
            'discord'   => $discord_tag,
            'email'     => $user->email,
            'nickname'  => $user->nickname,
            'races'     => $races->getClassicRaces($faction)->toJson(),
        ]);
    }

    /**
     * API request to update certain attributes about the user. This can only
     * be called via the JavaScript API.
     *
     * @return Illuminate\Http\Response
     */
    public function updateUserField(User $user, $field, Request $request)
    {
        abort_unless(Schema::hasColumn($user->getTable(), $field), 400);

        // The users table has the specified field...

        $validated_data = $request->validate([
            'value' => $this->getValidationRuleForField($field),
        ]);

        $user->{$field} = $validated_data['value'];
        $user->save();

        return response(null, 204);
    }

    protected function getValidationRuleForField($field)
    {
        switch ($field) {
            case 'nickname':
                return [
                    'nullable',
                    'alpha_num',
                    'between:3,32',
                ];
                break;
            case 'email':
                return [
                    'nullable',
                    'email',
                ];
                break;
        }
    }

    public function unlinkDiscord(User $user)
    {
        $user->discord_user_id = null;
        $user->save();

        return response(null, 204);
    }
}
