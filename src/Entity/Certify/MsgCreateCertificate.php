<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify;

use Exception;
use KatenaChain\Client\Entity\Certify\Certificate\CertificateInterface;
use KatenaChain\Client\Entity\Certify\Certificate\V1\Certificate;
use KatenaChain\Client\Entity\MessageInterface;

/**
 * MsgCreateCertificate is a wrapper to indicate that a create certificate action should be applied in a transaction.
 * It should implement the MessageInterface.
 */
class MsgCreateCertificate implements MessageInterface
{
    const CERTIFICATES_MAPPING = [
        Certificate::TYPE => 'KatenaChain\Client\Entity\Certify\Certificate\V1\Certificate',
    ];
    const TYPE = "certify/MsgCreateCertificate";

    /**
     * @var CertificateInterface
     */
    protected $certificate;

    /**
     * MsgCreateCertificate constructor.
     * @param CertificateInterface $certificate
     */
    public function __construct(CertificateInterface $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * certificate getter.
     * @return CertificateInterface
     */
    public function getCertificate(): CertificateInterface
    {
        return $this->certificate;
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
     * toArray returns the array representation of a MessageCreateCertificate (MessageInterface requirement).
     * It indicates which message action we want to sign.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'value' => [
                'certificate' => $this->certificate->toArray()
            ],
        ];
    }

    /**
     * fromArray accepts an array representation of a MsgCreateCertificate and returns a new instance.
     * @param array $array
     * @return MsgCreateCertificate
     * @throws Exception
     */
    public static function fromArray(array $array): self
    {
        if (array_key_exists($array['certificate']['type'], self::CERTIFICATES_MAPPING)) {
            $certificate = call_user_func(self::CERTIFICATES_MAPPING[$array['certificate']['type']] . "::fromArray", $array['certificate']['value']);
            return new self($certificate);
        } else {
            throw new Exception(sprintf("unknown certificate type: %s", $array['certificate']['type']));
        }
    }
}
