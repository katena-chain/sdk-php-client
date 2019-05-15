<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Secret\V1;

use KatenaChain\Client\Entity\Certify\Secret\SecretInterface;

/**
 * Secret is the first version of a data secret to send in a transaction's message.
 */
class Secret implements SecretInterface
{
    const TYPE = "certify/SecretV1";

    /**
     * @var string
     */
    protected $companyChainID;

    /**
     * @var string
     */
    protected $certificateUuid;

    /**
     * @var Lock
     */
    protected $lock;

    /**
     * Secret constructor.
     * @param string $certificateUuid
     * @param string $companyChainID
     * @param Lock $lock
     */
    public function __construct(string $certificateUuid, string $companyChainID, Lock $lock)
    {
        $this->companyChainID = $companyChainID;
        $this->certificateUuid = $certificateUuid;
        $this->lock = $lock;
    }

    /**
     * certificateUuid getter (Secret interface requirement).
     * @return string
     */
    public function getCertificateUuid(): string
    {
        return $this->certificateUuid;
    }

    /**
     * companyChainID getter (Secret interface requirement).
     * @return string
     */
    public function getCompanyChainID(): string
    {
        return $this->companyChainID;
    }

    /**
     * lock getter.
     * @return Lock
     */
    public function getLock(): Lock
    {
        return $this->lock;
    }

    /**
     * type getter (Secret interface requirement).
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * toArray returns the array representation of a Secret (Secret interface requirement).
     * It indicates which version of a secret we want to encode.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'value' => [
                'certificate_uuid' => $this->certificateUuid,
                'company_chain_id' => $this->companyChainID,
                'lock'             => $this->lock->toArray(),
            ],
        ];
    }

    /**
     * fromArray accepts an array representation of a Secret and returns a new instance.
     * @param array $array
     * @return Secret
     */
    public static function fromArray(array $array): self
    {
        $lock = Lock::fromArray($array['lock']);
        return new self($array['certificate_uuid'], $array['company_chain_id'], $lock);
    }
}
