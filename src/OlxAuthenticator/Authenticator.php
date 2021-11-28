<?php

declare(strict_types=1);

namespace OlxAuthenticator;

use Parhomenko\Olx\Exceptions\UnknownCountryException;
use Parhomenko\Olx\OlxFactory;

class Authenticator
{
    /** @var string|int */
    private $clientId;
    /** @var string */
    private $clientSecret;
    /** @var string */
    private $redirectUrl;

    public function __construct($clientId, string $clientSecret, string $redirectUrl)
    {

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     * @throws UnknownCountryException
     */
    public function getOauthLink(): string
    {
        $api = OlxFactory::create(OlxFactory::UA, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        return $api->getUser()->getOAuthLink($this->redirectUrl, $this->clientId);
    }
}