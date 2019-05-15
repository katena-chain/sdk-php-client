<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity;

use DateTime;
use KatenaChain\Client\Utils\Formatter;

/**
 * SealState wraps a message and additional values in order to define the unique message state to be signed.
 */
class SealState
{
    /**
     * @var string
     */
    protected $chainID;

    /**
     * @var string
     */
    protected $nonceTime;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * SealState constructor.
     * @param string $chainID
     * @param string $nonceTime
     * @param MessageInterface $message
     */
    public function __construct(string $chainID, string $nonceTime, MessageInterface $message)
    {
        $this->chainID = $chainID;
        $this->nonceTime = $nonceTime;
        $this->message = $message;
    }

    /**
     * getSignBytes returns the sorted and marshaled values of a seal state.
     * @return string
     */
    public function getSignBytes(): string
    {
        return json_encode([
            'chain_id'   => $this->chainID,
            'message'    => $this->message->toArray(),
            'nonce_time' => $this->nonceTime,
        ], JSON_UNESCAPED_SLASHES);
    }

}
