<?php

declare(strict_types=1);

namespace OlxAuthenticator;

use GuzzleHttp\Exception\GuzzleException;
use Parhomenko\Olx\Api\User;
use Parhomenko\Olx\ApiInterface;
use Parhomenko\Olx\Exceptions\BadRequestException;
use Parhomenko\Olx\Exceptions\RefreshTokenException;
use Parhomenko\Olx\OlxFactory;
use Throwable;

class Authenticator
{
    /** @var string|int */
    private $clientId;
    /** @var string */
    private $redirectUrl;
    /** @var ApiInterface */
    private $api;

    public function __construct($clientId, string $clientSecret, string $redirectUrl, string $refreshToken = null)
    {
        $this->clientId = $clientId;
        $this->redirectUrl = $redirectUrl;
        $this->api = $api = OlxFactory::create(OlxFactory::UA, [
            'client_id' => $this->clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * @return string
     */
    public function getOauthLink(): string
    {
        return $this->api->getUser()->getOAuthLink($this->redirectUrl, (string) $this->clientId);
    }

    /**
     * @return User
     * @throws GuzzleException
     * @throws BadRequestException
     * @throws RefreshTokenException
     * @throws Throwable
     */
    public function refreshToken(): User
    {
        return $this->api->getUser()->refreshToken();
    }
}