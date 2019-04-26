<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity;

use KatenaChain\Client\Utils\Formatter;

/**
 * SealState wraps a message and additional values in order to define the unique message state to be signed.
 */
class SealState
{
    /**
     * @var string
     */
    protected $chainId;

    /**
     * @var \DateTime
     */
    protected $nonceTime;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * SealState constructor.
     * @param string $chainId
     * @param \DateTime $nonceTime
     * @param MessageInterface $message
     */
    public function __construct(string $chainId, \DateTime $nonceTime, MessageInterface $message)
    {
        $this->chainId = $chainId;
        $this->nonceTime = $nonceTime;
        $this->message = $message;
    }

    /**
     * toArray returns the array representation of a SealState (required for json marshaling).
     * @return array
     */
    public function toArray(): array
    {
        return [
            'chain_id'   => $this->chainId,
            'message'    => $this->message->toTypedArray(),
            'nonce_time' => Formatter::formatDate($this->nonceTime),
        ];
    }

    /**
     * toJson returns the json representation of a SealState.
     * @return string
     */
    public function toJson():string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_SLASHES);
    }

    /**
     * getSignBytes returns the sorted and marshaled values of a seal state.
     * @return array
     */
    public function getSignBytes(): array
    {
        return Formatter::string2ByteArray(
           $this->toJson()
        );
    }

}
