<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\PhpException;

use function trim;

class Php extends AbstractSerial
{

    /**
     * Convert an array to a php serialized string.
     */
    public static function encode($array): string
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

        try {
            $string = serialize($array);
        } catch (\Exception $e) {
            throw new PhpException("Serialize Error: " . $e->getMessage());
        }

        return $string;
    }


    /**
     * Convert a php serialized string to an array.
     */
    public static function decode(string $string): ArrayObject
    {
        if (trim($string) === "") {
            return new ArrayObject();
        }

        try {
            $array = unserialize($string);
        } catch (\Exception $e) {
            throw new PhpException("Serialize Error: " . $e->getMessage());
        }

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }
}
