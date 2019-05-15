<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity;

use KatenaChain\Client\Crypto\ED25519\PublicKey;

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
     * @param string $signature
     * @param PublicKey $signer
     */
    public function __construct(string $signature, PublicKey $signer)
    {
        $this->signature = $signature;
        $this->signer = $signer;
    }

    /**
     * toArray returns the array representation of a Seal.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'signature' => base64_encode($this->signature),
            'signer'    => base64_encode($this->signer->getKey())
        ];
    }

    /**
     * fromArray accepts an array representation of a Seal and returns a new instance.
     * @param array $array
     * @return Seal
     */
    public static function fromArray(array $array): self
    {
        $signer = new PublicKey(base64_decode($array['signer']));
        return new self(base64_decode($array['signature']), $signer);
    }

}
