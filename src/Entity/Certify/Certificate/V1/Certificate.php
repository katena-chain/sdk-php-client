<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Certificate\V1;

use KatenaChain\Client\Entity\Certify\Certificate\CertificateInterface;
use KatenaChain\Client\Entity\Certify\Certificate\DataSeal;

/**
 * Certificate is the first version of a data certificate to send in a transaction's message.
 */
class Certificate implements CertificateInterface
{
    const TYPE = "certify/CertificateV1";

    /**
     * @var string
     */
    protected $companyChainId;

    /**
     * @var string
     */
    protected $uUid;

    /**
     * @var DataSeal
     */
    protected $seal;

    /**
     * Certificate constructor.
     * @param string $uUid
     * @param string $companyChainId
     * @param string $signature
     * @param string $signer
     */
    public function __construct( string $uUid, string $companyChainId, string $signature, string $signer)
    {
        $this->companyChainId = $companyChainId;
        $this->uUid = $uUid;
        $this->seal = new DataSeal($signature, $signer);
    }

    /**
     * toArray returns the array representation of a Certificate (required for json marshaling).
     * @return array
     */
    public function toArray(): array
    {
        return [
            'company_chain_id' => $this->companyChainId,
            'seal'             => $this->seal->toArray(),
            'uuid'             => $this->uUid,
        ];
    }

    /**
     * toTypedArray returns the TypedArray representation of a Certificate (required for json marshaling).
     * It indicates which version of a certificate we want to encode.
     * @return array
     */
    public function toTypedArray(): array
    {
        return [
            'type'  => self::TYPE,
            'value' => $this->toArray(),
        ];
    }
}
