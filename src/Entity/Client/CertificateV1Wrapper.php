<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Client;

use KatenaChain\Client\Entity\Api\TransactionStatus;
use KatenaChain\Client\Entity\Certify\Certificate\V1\Certificate;

/**
 * CertificateV1Wrapper wraps a CertificateV1 with its blockchain status.
 */
class CertificateV1Wrapper
{
    /**
     * @var Certificate
     */
    protected $certificate;

    /**
     * @var TransactionStatus
     */
    protected $status;

    /**
     * CertificateV1Wrapper constructor.
     * @param Certificate $certificate
     * @param TransactionStatus $status
     */
    public function __construct(Certificate $certificate, TransactionStatus $status)
    {
        $this->certificate = $certificate;
        $this->status = $status;
    }

    /**
     * certificate getter.
     * @return Certificate
     */
    public function getCertificate(): Certificate
    {
        return $this->certificate;
    }

    /**
     * status getter.
     * @return TransactionStatus
     */
    public function getStatus(): TransactionStatus
    {
        return $this->status;
    }
}