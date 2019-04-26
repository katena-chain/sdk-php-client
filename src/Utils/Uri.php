<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils;


class Uri
{
    /**
     * getUri joins the base path and paths array and adds the query values to return a new uri.
     * @param string $basePath
     * @param array $paths
     * @param array $queryValues
     * @return string
     */
    public static function getUri(string $basePath, array $paths, array $queryValues = []) : string
    {
        array_walk($paths, function (&$path) {
            $path = trim($path, '/');
        });

        $fullUrl = $paths;
        array_unshift($fullUrl, rtrim($basePath, '/'));

        $fullUrl = implode('/', $fullUrl);

        if ($queryValues) {
            $fullUrl .= '?' . http_build_query($queryValues);
        }

        return $fullUrl;
    }

}
