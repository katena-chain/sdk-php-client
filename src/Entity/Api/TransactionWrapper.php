<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Api;

use Exception;

/**
 * TransactionWrapper wraps a Transaction with its blockchain status.
 */
class TransactionWrapper
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
     * TransactionWrapper constructor.
     * @param Transaction $transaction
     * @param TransactionStatus $status
     */
    public function __construct(Transaction $transaction, TransactionStatus $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
    }

    /**
     * status getter.
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }

    /**
     * transaction getter.
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * fromJSON accepts a json representation of a TransactionWrapper and returns a new instance.
     * @param string $json
     * @return TransactionWrapper
     * @throws Exception
     */
    public static function fromJSON(string $json): self
    {
        $jsonArray = json_decode($json, true);
        return self::fromArray($jsonArray);
    }

    /**
     * fromArray accepts an array representation of a TransactionWrapper and returns a new instance.
     * @param array $array
     * @return TransactionWrapper
     * @throws Exception
     */
    public static function fromArray(array $array): self
    {
        return new self(Transaction::fromArray($array['transaction']), TransactionStatus::fromArray($array['status']));
    }
}