<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use BlizzardApi\Service\WorldOfWarcraft;

/**
 * Character Select Controller
 *
 * This controller allows users to select their primary character. While not
 * required, it is recommended to access certain items.
 */
class CharacterSelectController extends Controller
{
    /**
     * Shows the user the character select page.
     *
     * @param  \BlizzardApi\Service\WorldOfWarcraft  $api
     * @return \Illuminate\Http\Response
     */
    public function showCharacterList(WorldOfWarcraft $api)
    {
        $user = Auth::user();

        $response = json_decode(
            $api->getProfileCharacters($user->access_token)
                ->getBody()
                ->getContents()
        );

        $characters = collect($response->characters);

        $characters = $characters->filter(function ($item, $key) {
            if (! property_exists($item, 'guild')) {
                return false;
            }

            return $item->guildRealm == 'Silvermoon' && $item->guild == 'The Road Less Travelled';
        });

        dd($characters);

        return view('template');
    }
}
