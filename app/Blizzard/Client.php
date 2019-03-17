<?php

namespace App\Blizzard;

use GuzzleHttp\Client as Guzzle;
use App\Blizzard\Regions;
use App\Blizzard\Tokens\Access;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Client
{
    use Regions;

    const API_URL_PATTERN              = 'https://{region}.api.blizzard.com';
    const API_ACCESS_TOKEN_URL_PATTERN = 'https://{region}.battle.net/oauth/token';

    protected $api_url;
    protected $api_access_token_url;
    protected $api_key;
    protected $api_secret;
    protected $access_tokens;
    protected $http;
    protected $locale;
    protected $region;

    /**
     * Constructor
     *
     * @param string $api_key    API key
     * @param string $api_secret API Secret key
     * @param string $region     Region
     * @param string $locale     Locale
     */
    public function __construct($api_key, $api_secret, $region = 'us', $locale = 'en_us')
    {
        $options = [
            'api_key'    => $api_key,
            'api_secret' => $api_secret,
            'region'     => strtolower($region),
            'locale'     => strtolower($locale),
        ];

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver, $options['region']);

        $options = $resolver->resolve($options);

        $this->api_key    = $options['api_key'];
        $this->api_secret = $options['api_secret'];
        $this->region     = $options['region'];
        $this->locale     = $options['locale'];

        $this->updateApiUrl($options['region']);
        $this->updateApiAccessTokenUrl($options['region']);
    }

    public function getApiUrl()
    {
        return $this->api_url;
    }

    public function getApiAccessTokenUrl()
    {
        return $this->api_access_token_url;
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    public function getApiSecret()
    {
        return $this->api_secret;
    }

    public function setApiSecret($api_secret)
    {
        $this->api_secret = $api_secret;

        return $this;
    }

    public function getRegion()
    {
        return strtolower($this->region);
    }

    public function setRegion($region)
    {
        $this->region = strtolower($region);

        $this->updateApiUrl($region);
        $this->updateApiAccessTokenUrl($region);

        return $this;
    }

    public function getLocale()
    {
        return strtolower($this->locale);
    }

    public function setLocale($locale)
    {
        $this->locale = strtolower($locale);

        return $this;
    }

    public function getAccessToken()
    {
        if (null === $this->access_tokens) {
            $this->access_tokens = [];
        }

        if (! array_key_exists($this->getRegion(), $this->access_tokens)) {
            $this->access_tokens[$this->getRegion()] = $this->requestAccessToken();
        }

        return $this->access_tokens[$this->getRegion()]->getToken();
    }

    public function setAccessToken(Access $access_token)
    {
        $this->access_tokens[$this->getRegion()] = $access_token;

        return $this;
    }

    protected function updateApiUrl($region)
    {
        $this->api_url = str_replace('{region}', strtolower($region), self::API_URL_PATTERN);

        return $this;
    }

    protected function updateApiAccessTokenUrl($region)
    {
        $this->api_access_token_url = str_replace('{region}', strtolower($region), self::API_ACCESS_TOKEN_URL_PATTERN);

        return $this;
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver Symfony options resolver
     * @param string          $region   Region
     *
     * @throws InvalidOptionsException
     */
    protected function configureOptions(OptionsResolver $resolver, $region)
    {
        if (isset(self::$regions[$region])) {
            $locales = self::$regions[$region];
        } else {
            throw new InvalidOptionsException(
                sprintf(
                    'The option "region" with value "%s" is invalid. Accepted values are: "%s".',
                    $region,
                    implode('", "', array_keys(self::$regions))
                )
            );
        }

        $resolver->setRequired(['api_key', 'api_secret', 'region', 'locale'])
                 ->setAllowedTypes('api_key', 'string')
                 ->setAllowedTypes('api_secret', 'string')
                 ->setAllowedTypes('region', 'string')
                 ->setAllowedValues('region', array_keys(self::$regions))
                 ->setAllowedTypes('locale', 'string')
                 ->setAllowedValues('locale', $locales);
    }

    /**
     * Request an Access Token from Blizzard
     *
     * @return Access
     *
     * @throws \HttpResponseException
     */
    protected function requestAccessToken()
    {
        $options = [
            'form_params' => [
                'grant_type'    => 'client_credentials',
            ],
            'auth' => [
                $this->getApiKey(),
                $this->getApiSecret(),
            ],
        ];

        $result = (new Guzzle())->post($this->getApiAccessTokenUrl(), $options);

        if (200 === $result->getStatusCode()) {
            return Access::fromJson(json_decode($result->getBody()->getContents()));
        } else {
            throw new \HttpResponseException('Invalid Response');
        }
    }
}
