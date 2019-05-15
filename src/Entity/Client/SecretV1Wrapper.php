<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Client;

use KatenaChain\Client\Entity\Api\TransactionStatus;
use KatenaChain\Client\Entity\Certify\Secret\V1\Secret;

/**
 * SecretV1Wrapper wraps a SecretV1 with its blockchain status.
 */
class SecretV1Wrapper
{
    /**
     * @var Secret
     */
    protected $secret;

    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
     * SecretV1Wrapper constructor.
     * @param Secret $secret
     * @param TransactionStatus $status
     */
    public function __construct(Secret $secret, TransactionStatus $status)
    {
        $this->secret = $secret;
        $this->status = $status;
    }

    /**
     * secret getter.
     * @return Secret
     */
    public function getSecret(): Secret
    {
        return $this->secret;
    }

    /**
     * status getter.
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }
}