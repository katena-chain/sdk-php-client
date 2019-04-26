<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils;

use KatenaChain\Client\Crypto\PrivateKey;

class Crypto
{
    /**
     * createPrivateKeyFromBase64 accepts a base64 encoded ED25519 private key (88 chars) and returns an ED25519
     * private key.
     * @param string $privateKeyBase64
     * @return PrivateKey
     */
    public static function createPrivateKeyFromBase64(string $privateKeyBase64) : PrivateKey
    {
        return new PrivateKey(Formatter::string2ByteArray(base64_decode($privateKeyBase64)));
    }
}
