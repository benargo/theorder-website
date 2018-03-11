<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Services\RacesRepository;
use App\Services\ClassesRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\CharactersRepository;
use GuzzleHttp\Exception\ServerException;
use App\Exceptions\NoCharactersFoundException;

/**
 * Character Select Controller
 *
 * This controller allows users to select their primary character. While not
 * required, it is recommended to access certain items.
 */
class CharacterSelectController extends Controller
{
    /**
     * Contains the data to send to the view.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Construct the controller.
     *
     * @param  \App\Services\ClassesRepository $classes
     * @param  \App\Services\RacesRepository   $races
     * @return void
     */
    public function __construct(ClassesRepository $classes, RacesRepository $races)
    {
        $this->data['classes'] = $classes;
        $this->data['races'] = $races;
    }

    /**
     * Shows the user the character select page.
     *
     * @param  \App\Services\CharactersRepository  $characters
     * @return \Illuminate\Http\Response
     */
    public function showCharacterList(CharactersRepository $characters)
    {
        $this->data['user'] = Auth::user();

        try {
            $characters = $characters->getCharacters($this->data['user']);

            // Throw a warning if this user doesn't have any characters who
            // are a member of the guild...
            $silvermoon = $characters->filter(function ($item, $key) {
                if (! property_exists($item, 'guild')) {
                    return false;
                }

                return $item->guildRealm == 'Silvermoon' && $item->guild == 'The Road Less Travelled';
            });

            if ($silvermoon->isEmpty()) {
                $this->data['alert'] = __('account.errors.no_silvermoon_characters_found');
            }

            // Group the remaining characters by realm...
            $this->data['characters'] = $characters->sortBy('name')->groupBy('realm');
        }
        catch (ServerException $e) {
            $this->data['error'] = __('account.errors.battlenet_api_'.$e->getCode());
        }
        catch (NoCharactersFoundException $e) {
            $this->data['error'] = $e->getMessage();
        }

        return view('character_select', $this->data);
    }

    /**
     * Set the primary character for the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Services\CharactersRepository  $characters
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPrimaryCharacter(User $user, CharactersRepository $characters, Request $request)
    {
        // Validate the request...
        abort_unless($request->has(['realm', 'name']), 400);

        // Search the database...
        $character = Character::firstOrCreate(
            ['realm' => $request->input('realm'), 'name' => $request->input('name')]
        );

        $user->characters()->save($character);
        $user->mainCharacter()->save($character);
        $user->save();

        return response(null, 204);
    }
}
