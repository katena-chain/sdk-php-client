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
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Api\Handler;
use KatenaChain\Client\Crypto\ED25519\PrivateKey;
use KatenaChain\Client\Crypto\X25519\PublicKey;
use KatenaChain\Client\Entity\Client\CertificateV1Wrapper;
use KatenaChain\Client\Entity\Client\SecretV1Wrapper;
use KatenaChain\Client\Entity\Client\SecretV1Wrappers;
use KatenaChain\Client\Entity\Api\TransactionStatus;
use KatenaChain\Client\Entity\Certify\Certificate\V1\Certificate;
use KatenaChain\Client\Entity\Certify\Certificate\V1\DataSeal;
use KatenaChain\Client\Entity\Certify\Secret\V1\Lock;
use KatenaChain\Client\Entity\Certify\Secret\V1\Secret;
use KatenaChain\Client\Entity\Certify\MsgCreateCertificate;
use KatenaChain\Client\Entity\Certify\MsgCreateSecret;
use KatenaChain\Client\Entity\Api\Transaction;
use KatenaChain\Client\Entity\MessageInterface;
use KatenaChain\Client\Entity\Seal;
use KatenaChain\Client\Entity\SealState;
use KatenaChain\Client\Exceptions\ApiException;
use KatenaChain\Client\Utils\Formatter;
use SodiumException;

/**
 * Transactor provides helper function to hide the complexity of Transaction creation, signature and API dialog.
 */
class Transactor
{
    /**
     * @var PrivateKey
     */
    protected $msgSigner;

    /**
     * @var Handler
     */
    protected $apiHandler;

    /**
     * @var string
     */
    protected $companyChainID;

    /**
     * @var string
     */
    protected $chainID;

    /**
     * Transactor constructor.
     * @param string $apiUrl
     * @param string $companyChainID
     * @param string $chainID
     * @param PrivateKey $msgSigner
     */
    public function __construct(string $apiUrl, string $companyChainID, string $chainID = "", PrivateKey $msgSigner = null)
    {
        $this->apiHandler = new Handler($apiUrl);
        $this->chainID = $chainID;
        $this->msgSigner = $msgSigner;
        $this->companyChainID = $companyChainID;
    }

    /**
     * sendCertificateV1 wraps a Certificate (V1) in a MsgCreateCertificate, creates a transaction and sends it to the
     * API.
     * @param string $uuid
     * @param string $dataSignature
     * @param string $dataSigner
     * @return TransactionStatus
     * @throws ApiException
     * @throws SodiumException
     * @throws GuzzleException
     */
    public function sendCertificateV1(string $uuid, string $dataSignature, string $dataSigner): TransactionStatus
    {
        $dataSeal = new DataSeal($dataSignature, $dataSigner);
        $certificate = new Certificate(
            $uuid,
            $this->companyChainID,
            $dataSeal
        );
        $message = new MsgCreateCertificate($certificate);

        $transaction = $this->getTransaction($message);

        return $this->apiHandler->sendCertificate($transaction);
    }

    /**
     * retrieveCertificateV1 fetches the API to find the corresponding transaction and converts its content to a
     * Certificate (V1) with its blockchain status.
     * @param string $uuid
     * @return CertificateV1Wrapper
     * @throws ApiException
     * @throws GuzzleException
     * @throws Exception
     */
    public function retrieveCertificateV1(string $uuid): CertificateV1Wrapper
    {
        $transactionWrapper = $this->apiHandler->retrieveCertificate($this->companyChainID, $uuid);
        if ($transactionWrapper->getTransaction()->getMessage()->getType() === MsgCreateCertificate::TYPE) {
            /**
             * @var MsgCreateCertificate $message
             */
            $message = $transactionWrapper->getTransaction()->getMessage();
            if ($message->getCertificate()->getType() === Certificate::TYPE) {
                /**
                 * @var Certificate $certificate
                 */
                $certificate = $message->getCertificate();
                return new CertificateV1Wrapper($certificate, $transactionWrapper->getStatus());
            } else {
                throw new Exception(sprintf("bad certificate type: %s", $message->getCertificate()->getType()));
            }
        } else {
            throw new Exception(sprintf("bad message type: %s", $transactionWrapper->getTransaction()->getMessage()->getType()));
        }
    }

    /**
     * sendSecretV1 wraps a Secret (V1) in a MsgCreateSecret, creates a transaction and sends it to the API.
     * @param string $certificateUuid
     * @param PublicKey $lockEncryptor
     * @param string $lockNonce
     * @param string $lockContent
     * @return TransactionStatus
     * @throws GuzzleException
     * @throws SodiumException
     * @throws ApiException
     */
    public function sendSecretV1(string $certificateUuid, PublicKey $lockEncryptor, string $lockNonce, string $lockContent): TransactionStatus
    {
        $lock = new Lock($lockEncryptor, $lockNonce, $lockContent);
        $secret = new Secret(
            $certificateUuid,
            $this->companyChainID,
            $lock
        );
        $message = new MsgCreateSecret($secret);

        $transaction = $this->getTransaction($message);

        return $this->apiHandler->sendSecret($transaction, $this->companyChainID, $certificateUuid);
    }

    /**
     * retrieveSecretsV1 fetches the API to find the corresponding transactions and converts their content to a Secret
     * (V1) with its blockchain status.
     * @param string $uuid
     * @return SecretV1Wrappers
     * @throws ApiException
     * @throws GuzzleException
     * @throws Exception
     */
    public function retrieveSecretsV1(string $uuid): SecretV1Wrappers
    {
        $transactionWrappers = $this->apiHandler->retrieveSecrets($this->companyChainID, $uuid);
        $secretV1WrappersArray = [];
        foreach ($transactionWrappers->getTransactions() as $transactionWrapper) {
            if ($transactionWrapper->getTransaction()->getMessage()->getType() === MsgCreateSecret::TYPE) {
                /**
                 * @var MsgCreateSecret $message
                 */
                $message = $transactionWrapper->getTransaction()->getMessage();
                if ($message->getSecret()->getType() === Secret::TYPE) {
                    /**
                     * @var Secret $secret
                     */
                    $secret = $message->getSecret();
                    $secretV1WrappersArray[] = new SecretV1Wrapper($secret, $transactionWrapper->getStatus());
                } else {
                    throw new Exception(sprintf("bad secret type: %s", $message->getSecret()->getType()));
                }
            } else {
                throw new Exception(sprintf("bad message type: %s", $transactionWrapper->getTransaction()->getMessage()->getType()));
            }
        }
        return new SecretV1Wrappers($secretV1WrappersArray, $transactionWrappers->getTotal());
    }

    /**
     * getTransaction signs a message and returns a new transaction ready to be sent.
     * @param MessageInterface $message
     * @return Transaction
     * @throws Exception
     * @throws SodiumException
     */
    public function getTransaction(MessageInterface $message): Transaction
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone("UTC"));

        $nonceTime = Formatter::formatDate($now);

        $sealDoc = new SealState($this->chainID, $nonceTime, $message);
        $sealDocBytes = $sealDoc->getSignBytes();

        if (is_null($this->msgSigner)) {
            throw new Exception("impossible to create transactions without a private key");
        }
        $msgSignature = $this->msgSigner->sign($sealDocBytes);
        $seal = new Seal($msgSignature, $this->msgSigner->getPublicKey());

        return new Transaction($message, $seal, $nonceTime);
    }
}
