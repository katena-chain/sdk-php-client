<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify;


use KatenaChain\Client\Entity\Certify\Certificate\CertificateInterface;
use KatenaChain\Client\Entity\MessageInterface;

/**
 * MessageCreateCertificate is wrapper to indicate that a create certificate action should be applied in a transaction.
 */
class MessageCreateCertificate implements MessageInterface
{
    const TYPE = "certify/MsgCreateCertificate";

    /**
     * @var CertificateInterface
     */
    protected $certificate;

    /**
     * MessageCreateCertificate constructor.
     * @param CertificateInterface $certificate
     */
    public function __construct(CertificateInterface $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * toArray returns the array representation of a MessageCreateCertificate (required for json marshaling).
     * @return array
     */
    public function toArray(): array
    {
        return [
            'certificate' => $this->certificate->toTypedArray()
        ];
    }

    /**
     * toTypedArray returns the TypedArray representation of a MessageCreateCertificate (required for json marshaling).
     * It indicates which message action we want to sign.
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
