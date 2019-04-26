<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity;

/**
 * MessageInterface sets the default methods a real message must implement.
 */
interface MessageInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function toTypedArray(): array;
}
