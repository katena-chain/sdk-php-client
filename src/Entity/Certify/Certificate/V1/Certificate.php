<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Certificate\V1;

use KatenaChain\Client\Entity\Certify\Certificate\CertificateInterface;

/**
 * CertificateV1 is the first version of a certificate to send in a transaction's message.
 * It should implement the CertificateInterface.
 */
class Certificate implements CertificateInterface
{
    const TYPE = "certify/CertificateV1";

    /**
     * @var string
     */
    protected $companyChainID;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var DataSeal
     */
    protected $seal;

    /**
     * Certificate constructor.
     * @param string $uuid
     * @param string $companyChainID
     * @param DataSeal $dataSeal
     */
    public function __construct(string $uuid, string $companyChainID, DataSeal $dataSeal)
    {
        $this->companyChainID = $companyChainID;
        $this->uuid = $uuid;
        $this->seal = $dataSeal;
    }

    /**
     * seal getter.
     * @return DataSeal
     */
    public function getSeal(): DataSeal
    {
        return $this->seal;
    }

    /**
     * uuid getter (CertificateInterface requirement).
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * companyChainID getter (CertificateInterface requirement).
     * @return string
     */
    public function getCompanyChainID(): string
    {
        return $this->companyChainID;
    }

    /**
     * type getter (CertificateInterface requirement).
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * toArray returns the array representation of a Certificate (CertificateInterface requirement).
     * It indicates which version of a certificate we want to encode.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'value' => [
                'company_chain_id' => $this->companyChainID,
                'seal'             => $this->seal->toArray(),
                'uuid'             => $this->uuid,
            ],
        ];
    }

    /**
     * fromArray accepts an array representation of a Certificate and returns a new instance.
     * @param array $array
     * @return Certificate
     */
    public static function fromArray(array $array): self
    {
        $seal = DataSeal::fromArray($array['seal']);
        return new self($array['uuid'], $array['company_chain_id'], $seal);
    }
}
