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

        // http://localhost:8080/verify/7/a6ad00ac113a19d953efb91820d8788e2263b28a?expiration=1733301834&signature=795f3b7996426d39a73d57ba9861a716fd94a0645820cee65c045842758cee56
        // {BASE_URL}/verify/{USER_ID}/{EMAIL_HASH}?expiration={EXPIRATION_TIMESTAMP}&signature={SIGNATURE}
        $url       = $this->routeParser->urlFor($routeName, $params, $query);
        $url       = $baseUrl.$url;
        $signature = hash_hmac('sha256', $url, $secretKey);
        $url       = $this->routeParser->urlFor($routeName, $params, $query + ['signature' => $signature]);

        return $baseUrl.$url;
    }

}
