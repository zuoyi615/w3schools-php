<?php

declare(strict_types=1);

namespace App;

use Slim\Interfaces\RouteParserInterface;

readonly class SignedUrl
{

    public function __construct(private Config $config, private RouteParserInterface $routeParser) {}

    public function fromRoute(string $routeName, array $params, array $query): string
    {
        $baseUrl   = trim($this->config->get('app_url'), '/');
        $secretKey = trim($this->config->get('app_key'), ' ');

        // {BASE_URL}/verify/{USER_ID}/{EMAIL_HASH}?expiration={EXPIRATION_TIMESTAMP}&signature={SIGNATURE}
        $url       = $this->routeParser->urlFor($routeName, $params, $query);
        $url       = $baseUrl.$url;
        $signature = hash_hmac('sha256', $url, $secretKey);
        $url       = $this->routeParser->urlFor($routeName, $params, $query + ['signature' => $signature]);

        return $baseUrl.$url;
    }

}
