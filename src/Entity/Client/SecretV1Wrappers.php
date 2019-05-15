<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Client;

/**
 * SecretV1Wrappers wraps a list of SecretV1Wrapper with the total transactions available in the blockchain.
 * The API by default, will only returns 10 transactions.
 */
class SecretV1Wrappers
{
    /**
     * @var SecretV1Wrapper[]
     */
    protected $secrets;

    /**
     * @var int
     */
    protected $total;

    /**
     * SecretV1Wrappers constructor.
     * @param SecretV1Wrapper[] $secrets
     * @param int $total
     */
    public function __construct(array $secrets, int $total)
    {
        $this->secrets = $secrets;
        $this->total = $total;
    }

    /**
     * total getter.
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * secrets getter.
     * @return SecretV1Wrapper[]
     */
    public function getSecrets(): array
    {
        return $this->secrets;
    }
}