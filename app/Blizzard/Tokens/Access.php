<?php

namespace App\Blizzard\Tokens;

use Carbon\Carbon;
use Blizzard\Tokens\Exceptions\Expired;

class Access
{
    protected $token;
    protected $token_type;
    protected $expires_in;
    protected $created_at;
    protected $expires_at;

    /**
     * Constructor
     *
     * @param string $access_token Access token
     * @param string $token_type   Token type
     * @param int    $expires_in   Expires in (seconds)
     */
    public function __construct($access_token, $token_type, $expires_in)
    {
        $this->token = $access_token;
        $this->token_type = $token_type;
        $this->expires_in = intval($expires_in);
        $this->created_at = Carbon::now();
        $this->expires_at = new Carbon();
        $this->expires_at->addSeconds($this->expires_in);
    }

    /**
     * Create token from json object
     *
     * @param \stdClass $json_object JSON object
     *
     * @return Access
     */
    public static function fromJson($json_object)
    {
        return new self($json_object->access_token, $json_object->token_type, $json_object->expires_in);
    }

    /**
     * Check if the token is expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Get the token string
     *
     * @return string
     *
     * @throws Expired
     */
    public function getToken()
    {
        if ($this->isExpired()) {
            throw new Expired('Token has expired');
        }

        return $this->token;
    }
}
