<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Utils;


class Formatter
{
    /**
     * @param string $string
     * @return array
     */
    public static function string2ByteArray(string $string): array
    {
        return unpack('C*', $string);
    }

    /**
     * @param array $byteArray
     * @return string
     */
    public static function byteArray2String(array $byteArray): string
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }

    /**
     * @param array $byteArray
     * @return string
     */
    public static function byteArray2Hex(array $byteArray): string
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }

    /**
     * @param string $hexString
     * @return array
     */
    public static function hex2ByteArray(string $hexString): array
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function string2Hex(string $string): string
    {
        return bin2hex($string);
    }

    /**
     * @param string $hexString
     * @return string
     */
    public static function hex2String(string $hexString): string
    {
        return hex2bin($hexString);
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public static function formatDate(\DateTime $dateTime): string
    {
        return $dateTime->format("Y-m-d\TH:i:s\Z");
    }
}
