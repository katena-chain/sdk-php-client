<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils\Api;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Client is a GuzzleHttp\Client wrapper to dialog with a JSON API.
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Client constructor.
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => $apiUrl]);
    }

    /**
     * post do a POST HTTP request.
     * @param $uri
     * @param $body
     * @return ResponseInterface
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, string $body): ResponseInterface
    {
        return $this->client->request(
            'POST',
            $uri,
            [
                'body' => $body
            ]
        );
    }
}
