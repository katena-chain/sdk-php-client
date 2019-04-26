<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity;

use KatenaChain\Client\Crypto\PublicKey;
use KatenaChain\Client\Utils\Formatter;

/**
 * Seal is a wrapper to an ED25519 signature and its corresponding ED25519 public key.
 */
class Seal
{
    /**
     * @var PublicKey
     */
    protected $signer;

    /**
     * @var string
     */
    protected $signature;

    /**
     * Seal constructor.
     * @param array $signature
     * @param PublicKey $signer
     */
    public function __construct(array $signature, PublicKey $signer)
    {
        $this->signature = $signature;
        $this->signer = $signer;
    }

    /**
     * toArray returns the array representation of a Seal (required for json marshaling).
     * @return array
     */
    public function toArray() :array
    {
        return [
            'signature' => base64_encode(Formatter::byteArray2String($this->signature)),
            'signer' => $this->signer->toBase64(),
        ];
    }

}
