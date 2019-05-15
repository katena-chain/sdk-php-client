<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils;

use KatenaChain\Client\Crypto\ED25519;
use KatenaChain\Client\Crypto\X25519;
use ParagonIE_Sodium_Compat;
use SodiumException;

class Crypto
{
    /**
     * createPrivateKeyED25519FromBase64 accepts a base64 encoded ED25519 private key (88 chars) and returns an ED25519
     * private key.
     * @param string $privateKeyBase64
     * @return ED25519\PrivateKey
     */
    public static function createPrivateKeyED25519FromBase64(string $privateKeyBase64): ED25519\PrivateKey
    {
        return new ED25519\PrivateKey(base64_decode($privateKeyBase64));
    }

    /**
     * createPrivateKeyX25519FromBase64 accepts a base64 encoded X25519 private key (44 chars) and returns an X25519
     * private key.
     * @param string $privateKeyBase64
     * @return X25519\PrivateKey
     */
    public static function createPrivateKeyX25519FromBase64(string $privateKeyBase64): X25519\PrivateKey
    {
        return new X25519\PrivateKey(base64_decode($privateKeyBase64));
    }

    /**
     * createPublicKeyX25519FromBase64 accepts a base64 encoded X25519 public key (44 chars) and returns an X25519
     * public key.
     * @param string $publicKeyBase64
     * @return X25519\PublicKey
     */
    public static function createPublicKeyX25519FromBase64(string $publicKeyBase64): X25519\PublicKey
    {
        return new X25519\PublicKey(base64_decode($publicKeyBase64));
    }

    /**
     * createNewKeysX25519 returns a new X25519 key pair.
     * @return array ["privateKey" => X25519\PrivateKey, "publicKey" => X25519\PublicKey]
     * @throws SodiumException
     */
    public static function createNewKeysX25519(): array
    {
        $keyPair = ParagonIE_Sodium_Compat::crypto_box_keypair();
        return [
            'privateKey' => new X25519\PrivateKey(ParagonIE_Sodium_Compat::crypto_box_secretkey($keyPair)),
            'publicKey'  => new X25519\PublicKey(ParagonIE_Sodium_Compat::crypto_box_publickey($keyPair)),
        ];
    }
}
