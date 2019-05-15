<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Api;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Utils\Uri;

/**
 * Client is a GuzzleHttp\Client wrapper to dialog with a JSON API.
 */
class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzleClient;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * Client constructor.
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->guzzleClient = new GuzzleHttp\Client();
    }

    /**
     * get wraps the doRequest method to do a GET HTTP request.
     * @param string $route
     * @param array $queryValues
     * @return RawResponse
     * @throws GuzzleException
     */
    public function get(string $route, array $queryValues = []): RawResponse
    {
        return $this->doRequest("GET", $route, "", $queryValues);
    }

    /**
     * post wraps the doRequest method to do a POST HTTP request.
     * @param string $route
     * @param string $body
     * @param array $queryValues
     * @return RawResponse
     * @throws GuzzleException
     */
    public function post(string $route, string $body, array $queryValues = []): RawResponse
    {
        return $this->doRequest("POST", $route, $body, $queryValues);
    }

    /**
     * doRequest uses the GuzzleHttp\Client to call a distant api and returns a response.
     * @param string $method
     * @param string $route
     * @param string $body
     * @param array $queryValues
     * @return RawResponse
     * @throws GuzzleException
     */
    private function doRequest(string $method, string $route, string $body = "", array $queryValues = []): RawResponse
    {
        $uri = Uri::getUri($this->apiUrl, [$route], $queryValues);
        $options = [];
        if ($body !== "") {
            $options['body'] = $body;
        }

        $response = $this->guzzleClient->request(
            $method,
            $uri,
            $options
        );

        return new RawResponse($response->getStatusCode(), $response->getBody()->getContents());
    }
}
