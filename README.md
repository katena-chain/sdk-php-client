# SDK PHP Client

## Requirements

- PHP >= 7.1
- ext-json

## Install

```bash
composer require katena-chain/sdk-php-client
```

## Usage

To rapidly interact with our API, you can use our `Transactor` helper. It handles all the steps needed to correctly
format, sign and send a transaction.

Feel free to explore and modify its code to meet your expectations.

Here is a snippet to demonstrate its usage:

```php
<?php
require_once 'vendor/autoload.php';

use KatenaChain\Client\Transactor;

$baseApiPath = "https://api.demo.katena.transchain.io";
$apiUrlSuffix = "api/v1";
$chainID = "katena-chain";
$privateKeyBase64 = "7C67DeoLnhI6jvsp3eMksU2Z6uzj8sqZbpgwZqfIyuCZbfoPcitCiCsSp2EzCfkY52Mx58xDOyQLb1OhC7cL5A==";
$companyChainID = "abcdef";

$client = new Transactor($baseApiPath, $apiUrlSuffix, $chainID, $privateKeyBase64, $companyChainID);

$uuid = "7529b5d0-16ba-4856-b139-dd6a48a87ad3";
$dataSignature = "document_signature_value";
$dataSigner = "document_signer_value";

try {
    $response = $client->sendCertificate($uuid, $dataSignature, $dataSigner);
    echo "API status code : " . $response->getStatusCode() . PHP_EOL;
    echo "API body        : " . $response->getBody();
} catch (Exception $e) {
    echo $e->getCode() . " : " . $e->getMessage();
}
```

## Katena documentation

For more information, check the [katena documentation](https://doc.katena.transchain.io)