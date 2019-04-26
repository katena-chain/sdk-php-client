<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Crypto;

use KatenaChain\Client\Utils\Formatter;

/**
 * AbstractKey holds a binary key
 */
abstract class AbstractKey
{
    /**
     * @var array
     */
    protected $key;

    /**
     * AbstractKey constructor.
     * @param array $key (bytes array)
     */
    public function __construct(array $key)
    {
        $this->key = $key;
    }

    /**
     * toBase64 returns the base64 value of a binary key.
     * @return string
     */
    public function toBase64()
    {
        return base64_encode(Formatter::byteArray2String($this->key));
    }
}
