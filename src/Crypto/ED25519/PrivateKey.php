<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Crypto\ED25519;

use KatenaChain\Client\Crypto\AbstractKey;
use ParagonIE_Sodium_Compat;
use SodiumException;

/**
 * PrivateKey is an ED25519 private key wrapper (64 bytes).
 */
class PrivateKey extends AbstractKey
{
    /**
     * @var PublicKey
     */
    protected $publicKey;

    /**
     * PrivateKey constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct($key);
        $this->publicKey = new PublicKey(substr($this->key, 32, 32));
    }

    /**
     * publicKey getter.
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        return $this->publicKey;
    }

    /**
     * sign accepts a message and returns its corresponding ED25519 signature.
     * @param string $message
     * @return string
     * @throws SodiumException
     */
    public function sign(string $message): string
    {
        return ParagonIE_Sodium_Compat::crypto_sign_detached($message, $this->key);
    }
}
