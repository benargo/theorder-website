<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use RestCord\DiscordClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    public function settingsPage(DiscordClient $discord, Request $request)
    {
        $user = $request->user();
        $discord_tag = null;

        if ($user->discord_user_id) {
            $discord_user = $discord->user->getUser(['user.id' => $user->discord_user_id]);
            $discord_tag = $discord_user->username . '#' . $discord_user->discriminator;
        }

        return view('account_settings', [
            'nickname' => $user->nickname,
            'email' => $user->email,
            'battletag' => $user->battletag,
            'discord' => $discord_tag,
        ]);
    }

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

    public function unlinkDiscord(User $user, Request $request)
    {
        $user->discord_user_id = null;
        $user->save();

        return response(null, 204);
    }
}
