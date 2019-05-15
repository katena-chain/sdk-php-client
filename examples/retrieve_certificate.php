<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use KatenaChain\Client\Exceptions\ApiException;
use KatenaChain\Client\Transactor;

function main()
{
    // Common Katena network information
    $apiUrl = "https://api.test.katena.transchain.io/api/v1";

    // Your Katena network information
    $companyChainID = "abcdef";

    // Create a Katena API helper
    $transactor = new Transactor($apiUrl, $companyChainID);

    // Certificate uuid you want to retrieve
    $certificateUuid = "2075c941-6876-405b-87d5-13791c0dc53a";

    try {

        // Retrieve a version 1 of a certificate from Katena blockchain
        $certificateV1Wrapper = $transactor->retrieveCertificateV1($certificateUuid);

        echo "Transaction status" . PHP_EOL;
        echo sprintf("  Code    : %d" . PHP_EOL, $certificateV1Wrapper->getStatus()->getCode());
        echo sprintf("  Message : %s" . PHP_EOL, $certificateV1Wrapper->getStatus()->getMessage());

        echo "CertificateV1" . PHP_EOL;
        echo sprintf("  Uuid             : %s" . PHP_EOL, $certificateV1Wrapper->getCertificate()->getUuid());
        echo sprintf("  Company chain id : %s" . PHP_EOL, $certificateV1Wrapper->getCertificate()->getCompanyChainID());
        echo sprintf("  Data signer      : %s" . PHP_EOL, $certificateV1Wrapper->getCertificate()->getSeal()->getSigner());
        echo sprintf("  Data signature   : %s" . PHP_EOL, $certificateV1Wrapper->getCertificate()->getSeal()->getSignature());

    } catch (ApiException $e) {
        echo $e;
    } catch (GuzzleException|Exception $e) {
        echo $e->getCode() . " " . $e->getMessage();
    }
}

main();