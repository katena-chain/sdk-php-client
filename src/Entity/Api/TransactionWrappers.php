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
 * TransactionWrappers wraps a list of TransactionWrapper with the total transactions available in the blockchain.
 * The API by default, will only returns 10 transactions.
 */
class TransactionWrappers
{
    /**
     * @var TransactionWrapper[]
     */
    protected $transactions;

    /**
     * @var int
     */
    protected $total;

    /**
     * TransactionWrappers constructor.
     * @param TransactionWrapper[] $transactions
     * @param int $total
     */
    public function __construct(array $transactions, int $total)
    {
        $this->transactions = $transactions;
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
     * transactions getter.
     * @return TransactionWrapper[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * fromJSON accepts a json representation of a TransactionWrappers and returns a new instance.
     * @param string $json
     * @return TransactionWrappers
     * @throws Exception
     */
    public static function fromJSON(string $json): self
    {
        $jsonArray = json_decode($json, true);
        $transactionWrappers = [];
        foreach ($jsonArray['transactions'] as $jsonTransactionWrapper) {
            $transactionWrappers[] = TransactionWrapper::fromArray($jsonTransactionWrapper);
        }
        return new self($transactionWrappers, $jsonArray['total']);
    }
}