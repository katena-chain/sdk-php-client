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
    $chainID = "katena-chain-test";

    // Your Katena network information
    $privateKeyED25519Base64 = "7C67DeoLnhI6jvsp3eMksU2Z6uzj8sqZbpgwZqfIyuCZbfoPcitCiCsSp2EzCfkY52Mx58xDOyQLb1OhC7cL5A==";
    $companyChainID = "abcdef";

    // Convert your private key
    $privateKey = Crypto::createPrivateKeyED25519FromBase64($privateKeyED25519Base64);

    // Create a Katena API helper
    $transactor = new Transactor($apiUrl, $companyChainID, $chainID, $privateKey);

    // Off chain information you want to send
    $certificateUuid = "2075c941-6876-405b-87d5-13791c0dc53a";
    $dataSignature = "off_chain_data_signature_from_php";
    $dataSigner = "off_chain_data_signer_from_php";

    try {

        // Send a version 1 of a certificate on Katena blockchain
        $transactionStatus = $transactor->sendCertificateV1($certificateUuid, $dataSignature, $dataSigner);

        echo "Transaction status" . PHP_EOL;
        echo sprintf("  Code    : %d" . PHP_EOL, $transactionStatus->getCode());
        echo sprintf("  Message : %s" . PHP_EOL, $transactionStatus->getMessage());

    } catch (ApiException $e) {
        echo $e;
    } catch (GuzzleException|Exception $e) {
        echo $e->getCode() . " " . $e->getMessage();
    }
}

main();