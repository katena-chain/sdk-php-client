<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Crypto\X25519\PrivateKey;
use KatenaChain\Client\Crypto\X25519\PublicKey;
use KatenaChain\Client\Exceptions\ApiException;
use KatenaChain\Client\Transactor;
use KatenaChain\Client\Utils\Crypto;

function main()
{
    // Common Katena network information
    $apiUrl = "https://api.test.katena.transchain.io/api/v1";
    $chainID = "katena-chain-test";

    // Your Katena network information
    $privateKeyED25519Base64 = "7C67DeoLnhI6jvsp3eMksU2Z6uzj8sqZbpgwZqfIyuCZbfoPcitCiCsSp2EzCfkY52Mx58xDOyQLb1OhC7cL5A==";
    $companyChainID = "abcdef";

    // Convert your private key
    $privateKey = Crypto::createPrivateKeyED25519FromBase64($privateKeyED25519Base64);

    // Create a Katena API helper
    $transactor = new Transactor($apiUrl, $companyChainID, $chainID, $privateKey);

    // Secret information about a certificate you want to send
    $certificateUuid = "2075c941-6876-405b-87d5-13791c0dc53a";
    $content = "off_chain_data_aes_encryption_key_from_php";

    // The recipient public key able to decrypt the secret later
    $recipientPublicKeyX25519Base64 = "CgguJuEb+/cSHD4Jo8JcVRpwDlt834pFijvd2AdWIgE=";
    $recipientPublicKey = Crypto::createPublicKeyX25519FromBase64($recipientPublicKeyX25519Base64);

    try {

        // Ephemeral key pair (recommended) to encrypt the secret
        $senderEphemeralKeys = Crypto::createNewKeysX25519();
        /**
         * @var PublicKey $senderEphemeralPublicKey
         */
        $senderEphemeralPublicKey = $senderEphemeralKeys['publicKey'];
        /**
         * @var PrivateKey $senderEphemeralPrivateKey
         */
        $senderEphemeralPrivateKey = $senderEphemeralKeys['privateKey'];

        // Encrypt the secret
        $encryptedInfo = $senderEphemeralPrivateKey->seal($content, $recipientPublicKey);

        // Send a version 1 of a secret on Katena blockchain
        $transactionStatus = $transactor->sendSecretV1($certificateUuid, $senderEphemeralPublicKey, $encryptedInfo['nonce'], $encryptedInfo['encryptedMessage']);

        echo "Transaction status" . PHP_EOL;
        echo sprintf("  Code    : %d" . PHP_EOL, $transactionStatus->getCode());
        echo sprintf("  Message : %s" . PHP_EOL, $transactionStatus->getMessage());

    } catch (ApiException $e) {
        echo $e;
    } catch (SodiumException|GuzzleException|Exception $e) {
        echo $e->getCode() . " " . $e->getMessage();
    }
}

main();