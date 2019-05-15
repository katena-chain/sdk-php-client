<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Secret;

/**
 * SecretInterface sets the default methods a real secret must implement.
 */
interface SecretInterface
{
    /**
     * @return string
     */
    public function getCertificateUuid(): string;

    /**
     * @return string
     */
    public function getCompanyChainID(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $array
     * @return mixed
     */
    public static function fromArray(array $array);
}
