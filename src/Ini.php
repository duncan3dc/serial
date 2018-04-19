<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\IniException;
use function count;
use function is_array;
use function parse_ini_string;
use function var_export;

class Ini extends AbstractSerial
{

    /**
     * Convert an array to a ini serialized string.
     *
     * {@inheritDoc}
     */
    public static function encode($array)
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

        if (!is_array($array)) {
            return "";
        }

        return self::serialize($array);
    }


    /**
     * Convert a ini serialized string to an array.
     *
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        if (!$string) {
            return new ArrayObject();
        }

        try {
            $array =  parse_ini_string($string, true, \INI_SCANNER_TYPED);
        } catch (\Exception $e) {
            throw new IniException("Serialize Error: " . $e->getMessage());
        }

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }


    /**
     * Convert an array to a ini serialized string.
     *
     * @param array $array The data to serialize
     *
     * @return string
     */
    private static function serialize(array $array)
    {
        $string = "";

        foreach ($array as $key => $value) {
            $string .= "{$key} = " . var_export($value, true) . "\n";
        }

        return $string;
    }
}
