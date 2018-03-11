<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use BlizzardApi\Service\WorldOfWarcraft;
use App\Exceptions\NoCharactersFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CharactersRepository
{
    /**
     * Contains the World of Warcraft API instance.
     *
     * @var \BlizzardApi\Service\WorldOfWarcraft
     */
    protected $client;

    /**
     * Render the homepage.
     *
     * @param  \BlizzardApi\Service\WorldOfWarcraft  $client
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(WorldOfWarcraft $client)
    {
        $this->client = $client;
    }

    /**
     * Fetches the list of user characters.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @return \Illuminate\Support\Collection
     *
     * @throws \GuzzleHttp\Exception\ServerException
     * @throws \App\Exceptions\NoCharactersFoundException
     */
    public function getCharacters(Authenticatable $user)
    {
        // First check the cache for the list of characters
        if (Cache::tags(['battlenet', 'user_characters'])->has($user->id)) {
            return Cache::tags(['battlenet', 'user_characters'])->get($user->id);
        }

        // Fetch the list of characters from the API. This should always
        // fetch the latest, most up-to-date version...
        $response = json_decode(
            $this->client->getProfileCharacters($user->access_token)
                ->getBody()
                ->getContents()
        );

        $characters = collect($response->characters);

        // If the user doesn't have any characters we should throw an
        // exception, as we should not attempt to pass an empty collection
        // to the view...
        if ($characters->isEmpty()) {
            throw new NoCharactersFoundException('No characters were found.');
        }

        // Store the characters in the cache for an hour...
        Cache::tags(['battlenet', 'user_characters'])->put(
            $user->id,
            $characters,
            now()->addMinutes(60)
        );

        return $characters;
    }
}
