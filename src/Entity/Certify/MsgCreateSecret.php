<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify;

use Exception;
use KatenaChain\Client\Entity\Certify\Secret\SecretInterface;
use KatenaChain\Client\Entity\Certify\Secret\V1\Secret;
use KatenaChain\Client\Entity\MessageInterface;

/**
 * MsgCreateSecret is a wrapper to indicate that a create secret action should be applied in a transaction.
 * It should implement the MessageInterface.
 */
class MsgCreateSecret implements MessageInterface
{
    const SECRETS_MAPPING = [
        Secret::TYPE => 'KatenaChain\Client\Entity\Certify\Secret\V1\Secret',
    ];
    const TYPE = "certify/MsgCreateSecret";

    /**
     * @var SecretInterface
     */
    protected $secret;

    /**
     * MsgCreateSecret constructor.
     * @param SecretInterface $secret
     */
    public function __construct(SecretInterface $secret)
    {
        $this->secret = $secret;
    }

    /**
     * secret getter.
     * @return SecretInterface
     */
    public function getSecret(): SecretInterface
    {
        return $this->secret;
    }

    /**
     * type getter (MessageInterface requirement).
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * toArray returns the array representation of a MessageCreateSecret (MessageInterface requirement).
     * It indicates which message action we want to sign.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'value' => [
                'secret' => $this->secret->toArray()
            ],
        ];
    }

    /**
     * fromArray accepts an array representation of a MsgCreateSecret and returns a new instance.
     * @param array $array
     * @return MsgCreateSecret
     * @throws Exception
     */
    public static function fromArray(array $array): self
    {
        if (array_key_exists($array['secret']['type'], self::SECRETS_MAPPING)) {
            $secret = call_user_func(self::SECRETS_MAPPING[$array['secret']['type']] . "::fromArray", $array['secret']['value']);
            return new self($secret);
        } else {
            throw new Exception(sprintf("unknown secret type: %s", $array['secret']['type']));
        }
    }
}
