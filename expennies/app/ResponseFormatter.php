<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseFormatter
{

    const int DEFAULT_FLAGS
        = JSON_HEX_TAG |
        JSON_HEX_AMP |
        JSON_HEX_QUOT |
        JSON_HEX_APOS |
        JSON_THROW_ON_ERROR;

    public function asJson(
        Response $response,
        mixed    $data,
        int      $flags = self::DEFAULT_FLAGS
    ): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');

        $json = json_encode($data, $flags);
        $response->getBody()->write($json);

        return $response;
    }

    public function asDataTable(Response $response, array $data, int $draw, int $total): Response
    {
        return $this->asJson(
            $response,
            [
                'data' => $data,
                'draw' => $draw,
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
            ]
        );
    }

}
