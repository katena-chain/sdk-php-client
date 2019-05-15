<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils;

use DateTime;

class Formatter
{
    /**
     * formatDate format a DateTime to its RFC3339 representation.
     * @param DateTime $dateTime
     * @return string
     */
    public static function formatDate(DateTime $dateTime): string
    {
        return $dateTime->format("Y-m-d\TH:i:s\Z");
    }
}
