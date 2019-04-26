<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Api;

use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Utils\Api\Response;
use KatenaChain\Client\Utils\Uri;
use KatenaChain\Client\Utils\Api\Client;

/**
 * Handler provides helper methods to send and retrieve transactions without directly interacting with the HTTP Client.
 */
class Handler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiUrlSuffix;

    /**
     * Handler constructor.
     * @param string $apiUrl
     * @param string $apiUrlSuffix
     */
    public function __construct(string $apiUrl, string $apiUrlSuffix)
    {
        $this->client = new Client($apiUrl);
        $this->apiUrlSuffix = $apiUrlSuffix;
    }

    /**
     * sendCertificate accepts a transaction and sends it to the appropriate API route.
     * @param string $transaction
     * @return Response
     * @throws GuzzleException
     */
    public function sendCertificate(string $transaction): Response
    {
        $response = $this->client->post(Uri::getUri($this->apiUrlSuffix, ["/certificates/certify"]), $transaction);
        return new Response($response->getStatusCode(), $response->getBody()->getContents());
    }
}
