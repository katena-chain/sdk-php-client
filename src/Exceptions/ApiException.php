<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Exceptions;

use Exception;

/**
 * ApiException allows to wrap API errors.
 */
class ApiException extends Exception
{

    /**
     * fromJSON accepts a json representation of an ApiException and returns a new instance.
     * @param string $json
     * @return ApiException
     */
    public static function fromJSON(string $json): self
    {
        $jsonArray = json_decode($json, true);
        return new self($jsonArray['message'], $jsonArray['code']);
    }

    /**
     * __toString overrides the default string format of an exception.
     * @return string
     */
    public function __toString()
    {
        return sprintf("api error:" . PHP_EOL . "  Code: %d" . PHP_EOL . "  Message: %s" . PHP_EOL, $this->getCode(), $this->getMessage());
    }
}