<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Exceptions\ApiException;
use KatenaChain\Client\Transactor;
use KatenaChain\Client\Utils\Crypto;

function main()
{
    // Common Katena network information
    $apiUrl = "https://api.test.katena.transchain.io/api/v1";

    // Your Katena network information
    $companyChainID = "abcdef";

    // Create a Katena API helper
    $transactor = new Transactor($apiUrl, $companyChainID);

    // Your decryption private key
    $recipientPrivateKeyX25519Base64 = "/HYK9/xU3SSKNtylLEQs/MrjujgrxYkWuDFQ4A2QayQ=";
    $recipientPrivateKey = Crypto::createPrivateKeyX25519FromBase64($recipientPrivateKeyX25519Base64);

    // Certificate uuid you want to retrieve secrets
    $certificateUuid = "2075c941-6876-405b-87d5-13791c0dc53a";

    try {

        // Retrieve version 1 of secrets from Katena blockchain
        $secretV1Wrappers = $transactor->retrieveSecretsV1($certificateUuid);

        foreach ($secretV1Wrappers->getSecrets() as $secretV1Wrapper) {
            echo "Transaction status" . PHP_EOL;
            echo sprintf("  Code    : %d" . PHP_EOL, $secretV1Wrapper->getStatus()->getCode());
            echo sprintf("  Message : %s" . PHP_EOL, $secretV1Wrapper->getStatus()->getMessage());

            echo "SecretV1" . PHP_EOL;
            echo sprintf("  Certificate uuid  : %s" . PHP_EOL, $secretV1Wrapper->getSecret()->getCertificateUuid());
            echo sprintf("  Company chain id  : %s" . PHP_EOL, $secretV1Wrapper->getSecret()->getCompanyChainID());
            echo sprintf("  Lock encryptor    : %s" . PHP_EOL, base64_encode($secretV1Wrapper->getSecret()->getLock()->getEncryptor()->getKey()));
            echo sprintf("  Lock nonce        : %s" . PHP_EOL, base64_encode($secretV1Wrapper->getSecret()->getLock()->getNonce()));
            echo sprintf("  Lock content      : %s" . PHP_EOL, base64_encode($secretV1Wrapper->getSecret()->getLock()->getContent()));

            // Try to decrypt the content
            $decryptedContent = $recipientPrivateKey->open(
                $secretV1Wrapper->getSecret()->getLock()->getContent(),
                $secretV1Wrapper->getSecret()->getLock()->getEncryptor(),
                $secretV1Wrapper->getSecret()->getLock()->getNonce()
            );

            if ($decryptedContent === "") {
                $decryptedContent = "Unable to decrypt";
            }
            echo sprintf("  Decrypted content : %s" . PHP_EOL, $decryptedContent);
            echo PHP_EOL;
        }

    } catch (ApiException $e) {
        echo $e;
    } catch (GuzzleException|Exception $e) {
        echo $e->getCode() . " " . $e->getMessage();
    }
}

main();