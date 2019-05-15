<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Api;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Entity\Api\Transaction;
use KatenaChain\Client\Entity\Api\TransactionStatus;
use KatenaChain\Client\Entity\Api\TransactionWrapper;
use KatenaChain\Client\Entity\Api\TransactionWrappers;
use KatenaChain\Client\Exceptions\ApiException;

/**
 * Handler provides helper methods to send and retrieve transactions without directly interacting with the HTTP Client.
 */
class Handler
{
    const CERTIFICATES_ROUTE = "certificates";
    const CERTIFICATE_ROUTE = self::CERTIFICATES_ROUTE . "/%s-%s";
    const CERTIFICATE_CERTIFY_ROUTE = self::CERTIFICATES_ROUTE . "/certify";
    const SECRETS_ROUTE = self::CERTIFICATE_ROUTE . "/secrets";
    const SECRET_CERTIFY_ROUTE = self::SECRETS_ROUTE . "/certify";

    /**
     * @var Client
     */
    protected $apiClient;

    /**
     * Handler constructor.
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->apiClient = new Client($apiUrl);
    }

    /**
     * sendCertificate accepts a transaction and sends it to the appropriate certificate API route.
     * @param Transaction $transaction
     * @return TransactionStatus
     * @throws ApiException
     * @throws GuzzleException
     */
    public function sendCertificate(Transaction $transaction): TransactionStatus
    {
        return $this->sendTransaction(self::CERTIFICATE_CERTIFY_ROUTE, $transaction);
    }

    /**
     * sendSecret accepts a transaction and sends it to the appropriate API route.
     * @param Transaction $transaction
     * @param string $companyChainID
     * @param string $certificateUuid
     * @return TransactionStatus
     * @throws ApiException
     * @throws GuzzleException
     */
    public function sendSecret(Transaction $transaction, string $companyChainID, string $certificateUuid): TransactionStatus
    {
        return $this->sendTransaction(sprintf(self::SECRET_CERTIFY_ROUTE, $companyChainID, $certificateUuid), $transaction);
    }

    /**
     * retrieveCertificate fetches the API and returns a transaction wrapper.
     * @param string $companyChainID
     * @param string $uuid
     * @return TransactionWrapper
     * @throws ApiException
     * @throws GuzzleException
     * @throws Exception
     */
    public function retrieveCertificate(string $companyChainID, string $uuid): TransactionWrapper
    {
        try {
            $apiResponse = $this->apiClient->get(sprintf(self::CERTIFICATE_ROUTE, $companyChainID, $uuid));
        } catch (BadResponseException $e) {
            throw ApiException::fromJSON($e->getResponse()->getBody()->getContents());
        }
        return TransactionWrapper::fromJSON($apiResponse->getBody());
    }

    /**
     * retrieveSecrets fetches the API and returns a transaction wrapper list.
     * @param string $companyChainID
     * @param string $certificateUuid
     * @return TransactionWrappers
     * @throws ApiException
     * @throws GuzzleException
     * @throws Exception
     */
    public function retrieveSecrets(string $companyChainID, string $certificateUuid): TransactionWrappers
    {
        try {
            $apiResponse = $this->apiClient->get(sprintf(self::SECRETS_ROUTE, $companyChainID, $certificateUuid));
        } catch (BadResponseException $e) {
            throw ApiException::fromJSON($e->getResponse()->getBody()->getContents());
        }
        return TransactionWrappers::fromJSON($apiResponse->getBody());
    }

    /**
     * sendTransaction tries to send a transaction to the API and returns a transaction status or throws an api error.
     * @param string $route
     * @param Transaction $transaction
     * @return TransactionStatus
     * @throws ApiException
     * @throws GuzzleException
     */
    private function sendTransaction(string $route, Transaction $transaction): TransactionStatus
    {
        try {
            $apiResponse = $this->apiClient->post($route, $transaction->toJSON());
        } catch (BadResponseException $e) {
            throw ApiException::fromJSON($e->getResponse()->getBody()->getContents());
        }
        return TransactionStatus::fromJSON($apiResponse->getBody());
    }
}
