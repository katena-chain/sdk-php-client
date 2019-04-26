<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Certificate;

/**
 * DataSeal is a wrapper to a raw signature (16 < x < 128 bytes) and its corresponding raw signer (16 < x < 128 bytes).
 */
class DataSeal
{
    /**
     * @var string
     */
    protected $signer;

    /**
     * @var string
     */
    protected $signature;

    /**
     * DataSeal constructor.
     * @param string $signature
     * @param string $signer
     */
    public function __construct(string $signature, string $signer)
    {
        $this->signature = $signature;
        $this->signer = $signer;
    }

    /**
     * toArray returns the array representation of a DataSeal (required for json marshaling).
     * @return array
     */
    public function toArray() :array
    {
        return [
            'signature' => base64_encode($this->signature),
            'signer' => base64_encode($this->signer),
        ];
    }
}
