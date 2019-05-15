<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Api;

/**
 * TransactionStatus is the blockchain status of a transaction.
 */
class TransactionStatus
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * TransactionStatus constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * code getter.
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * message getter.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * fromJSON accepts a json representation of a TransactionStatus and returns a new instance.
     * @param string $json
     * @return TransactionStatus
     */
    public static function fromJSON(string $json): self
    {
        $jsonArray = json_decode($json, true);
        return self::fromArray($jsonArray);
    }

    /**
     * fromArray accepts an array representation of a TransactionStatus and returns a new instance.
     * @param array $array
     * @return TransactionStatus
     */
    public static function fromArray(array $array): self
    {
        return new self($array['code'], $array['message']);
    }
}