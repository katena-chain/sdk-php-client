<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Crypto;

/**
 * AbstractKey holds a string key
 */
abstract class AbstractKey
{
    /**
     * @var string
     */
    protected $key;

    /**
     * AbstractKey constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * key getter.
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
