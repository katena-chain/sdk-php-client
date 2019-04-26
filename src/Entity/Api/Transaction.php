<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Api;

use KatenaChain\Client\Crypto\PublicKey;
use KatenaChain\Client\Entity\MessageInterface;
use KatenaChain\Client\Entity\Seal;
use KatenaChain\Client\Utils\Formatter;

/**
 * Transaction wraps a message, its signature infos and the nonce time used to sign the message.
 */
class Transaction
{
    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var Seal
     */
    protected $seal;

    /**
     * @var \DateTime
     */
    protected $nonceTime;

    /**
     * Transaction constructor.
     * @param MessageInterface $message
     * @param array $messageSignature
     * @param PublicKey $publicKey
     * @param \DateTime $nonceTime
     */
    public function __construct(MessageInterface $message, array $messageSignature, PublicKey $publicKey, \DateTime $nonceTime)
    {
        $this->message = $message;
        $this->nonceTime = $nonceTime;
        $this->seal = new Seal($messageSignature, $publicKey);
    }

    /**
     * toArray returns the array representation of a Transaction (required for json marshaling).
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message->toArray(),
            'seal' => $this->seal->toArray(),
            'nonce_time' => Formatter::formatDate($this->nonceTime),
        ];
    }

    /**
     * toJson returns the json representation of a Transaction.
     * @return string
     */
    public function toJson() :string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_SLASHES);
    }
}
