# SDK PHP Client

Please use [sdk-php](https://github.com/katena-chain/sdk-php) instead.

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

## Examples

Detailed examples are provided in the `examples` folder to explain how to use our `Transactor` helper methods.

Available examples:
* Send a `Certificate`
* Retrieve a `Certificate`
* Encrypt and send a `Secret`
* Retrieve a list of `Secret`

For instance, to send a certificate:
```bash
php examples/send_certificate.php
```

## Katena documentation

For more information, check the [katena documentation](https://doc.katena.transchain.io).
