<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Api;

use DateTime;
use Exception;
use KatenaChain\Client\Entity\Certify\MsgCreateCertificate;
use KatenaChain\Client\Entity\Certify\MsgCreateSecret;
use KatenaChain\Client\Entity\MessageInterface;
use KatenaChain\Client\Entity\Seal;
use KatenaChain\Client\Utils\Formatter;

/**
 * Transaction wraps a message, its signature infos and the nonce time used to sign the message.
 */
class Transaction
{
    const MESSAGES_MAPPING = [
        MsgCreateCertificate::TYPE => 'KatenaChain\Client\Entity\Certify\MsgCreateCertificate',
        MsgCreateSecret::TYPE      => 'KatenaChain\Client\Entity\Certify\MsgCreateSecret',
    ];

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var Seal
     */
    protected $seal;

    /**
     * @var string
     */
    protected $nonceTime;

    /**
     * Transaction constructor.
     * @param MessageInterface $message
     * @param Seal $seal
     * @param string $nonceTime
     */
    public function __construct(MessageInterface $message, Seal $seal, string $nonceTime)
    {
        $this->message = $message;
        $this->nonceTime = $nonceTime;
        $this->seal = $seal;
    }

    /**
     * message getter.
     * @return MessageInterface
     */
    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    /**
     * toJSON returns the json representation of a Transaction.
     * @return string
     */
    public function toJSON(): string
    {
        return json_encode([
            'message'    => $this->message->toArray(),
            'nonce_time' => $this->nonceTime,
            'seal'       => $this->seal->toArray(),
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * fromArray accepts an array representation of a Transaction and returns a new instance.
     * @param array $array
     * @return Transaction
     * @throws Exception
     */
    public static function fromArray(array $array): self
    {
        if (array_key_exists($array['message']['type'], self::MESSAGES_MAPPING)) {
            $message = call_user_func(self::MESSAGES_MAPPING[$array['message']['type']] . "::fromArray", $array['message']['value']);
            $seal = Seal::fromArray($array['seal']);
            return new self($message, $seal, $array['nonce_time']);
        } else {
            throw new Exception(sprintf("unknown message type: %s", $array['message']['type']));
        }
    }
}
