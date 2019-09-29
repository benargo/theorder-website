<?php

namespace App\Blizzard;

use GuzzleHttp\Client;
use App\Blizzard\Client as BlizzardClient;
use Psr\Http\Message\ResponseInterface;

class Service
{
    protected $blizzard_client;
    protected $service_param;

    public function __construct(BlizzardClient $blizzard_client)
    {
        $this->blizzard_client = $blizzard_client;
    }

    /**
     * Request
     *
     * Make request with API url and specific URL suffix
     *
     * @param string $urlSuffix API URL method
     * @param array  $options   Options
     *
     * @return ResponseInterface
     */
    protected function request($url_suffix, array $options)
    {
        $client = new Client([
            'base_uri' => $this->blizzard_client->getApiUrl(),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->blizzard_client->getAccessToken(),
            ],
            // 'proxy' => 'http://52.166.58.138:3128',
        ]);

        $options = $this->generateQueryOptions($options);

        return $client->get($this->service_param.$url_suffix, $options);
    }

    /**
     * Generate query options
     *
     * Setting default option to given options array if it does have 'query' key,
     * otherwise creating 'query' key with default options
     *
     * @param array $options
     *
     * @return array
     */
    private function generateQueryOptions(array $options = [])
    {
        if (isset($options['query'])) {
            $result = $options['query'] + $this->getDefaultOptions();
        } else {
            $result['query'] = $options + $this->getDefaultOptions();
        }

        return $result;
    }

    /**
     * Get default options
     *
     * Get default query options from configured Blizzard Client
     *
     * @return array
     */
    private function getDefaultOptions()
    {
        return [
            'locale' => $this->blizzard_client->getLocale(),
            'apiKey' => $this->blizzard_client->getApiKey(),
        ];
    }
}
