<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Crypto;

use KatenaChain\Client\Utils\Formatter;

/**
 * PrivateKey is an ED25519 private key wrapper (64 bytes).
 */
class PrivateKey extends AbstractKey
{
    /**
     * @var string
     */
    protected $publicKey;

    /**
     * PrivateKey constructor.
     * @param array $key (byte array)
     */
    public function __construct(array $key)
    {
        parent::__construct($key);
        $this->publicKey = new PublicKey(array_slice($this->key, 32, 32));
    }

    /**
     * getPublicKey returns the underlying ED25519 public key.
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        return $this->publicKey;
    }

    /**
     * toString return the string representation of the binary key (required to sign)
     * @return string
     */
    protected function toString()
    {
        return Formatter::byteArray2String($this->key);
    }

    /**
     * sign accepts a message and returns its corresponding signature.
     * @param array $msg
     * @return array
     * @throws \SodiumException
     */
    public function sign(array $msg): array
    {
        $signature = \ParagonIE_Sodium_Compat::crypto_sign_detached(Formatter::byteArray2String($msg), $this->toString());
        return Formatter::string2ByteArray($signature);
    }
}
