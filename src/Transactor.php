<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client;

use DateTime;
use DateTimeZone;
use KatenaChain\Client\Api\Handler;
use KatenaChain\Client\Crypto\PrivateKey;
use KatenaChain\Client\Api\handler as ApiClient;
use KatenaChain\Client\Entity\Certify\Certificate\V1\Certificate;
use KatenaChain\Client\Entity\Certify\MessageCreateCertificate;
use KatenaChain\Client\Entity\Api\Transaction;
use KatenaChain\Client\Entity\SealState;
use KatenaChain\Client\Utils\Api\Response;
use KatenaChain\Client\Utils\Crypto;

/**
 * Transactor provides helper function to hide the complexity of Transaction creation, signature and API dialog.
 */
class Transactor
{
    /**
     * @var PrivateKey
     */
    protected $privateKey;

    /**
     * @var ApiClient
     */
    protected $apiClient;
    /**
     * @var string
     */
    protected $companyChainId;
    /**
     * @var string
     */
    protected $chainId;

    /**
     * Transactor constructor.
     * @param string $apiUrl
     * @param string $apiUrlSuffix
     * @param string $chainId
     * @param string $privateKey (base64)
     * @param string $companyChainId
     */
    public function __construct(string $apiUrl, string $apiUrlSuffix, string $chainId, string $privateKey, string $companyChainId)
    {
        $this->apiClient = new Handler($apiUrl, $apiUrlSuffix);
        $this->chainId = $chainId;
        $this->privateKey = Crypto::createPrivateKeyFromBase64($privateKey);
        $this->companyChainId = $companyChainId;
    }

    /**
     * sendCertificate creates a Certificate (V1) wrapped in a MessageCreateCertificate, signs it and sends it to the API.
     * @param string $uUid
     * @param string $signature
     * @param string $signer
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SodiumException
     * @throws \Exception
     */
    public function sendCertificate(string $uUid, string $signature, string $signer): Response
    {
        $certificate = new Certificate(
            $uUid,
            $this->companyChainId,
            $signature,
            $signer
        );

        $nonceTime = new DateTime();
        $nonceTime->setTimezone(new DateTimeZone("UTC"));

        $message = new MessageCreateCertificate($certificate);
        $sealDoc = new SealState($this->chainId, $nonceTime, $message);
        $sealDocBytes = $sealDoc->getSignBytes();

        $messageSignature = $this->privateKey->sign($sealDocBytes);

        $transaction = new Transaction($message, $messageSignature, $this->privateKey->getPublicKey(), $nonceTime);

        return $this->apiClient->sendCertificate($transaction->toJson());
    }
}
