<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\JsonException;

use function assert;
use function is_string;
use function trim;

class Json extends AbstractSerial
{

    /**
     * Convert an array to a JSON string.
     */
    public static function encode($array): string
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

        $string = json_encode($array);

        static::checkLastError();
        assert(is_string($string));

        return $string;
    }


    /**
     * Convert a JSON string to an array.
     */
    public static function decode(string $string): ArrayObject
    {
        if (trim($string) === "") {
            return new ArrayObject();
        }

        $array = json_decode($string, true);

        static::checkLastError();

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }


    /**
     * Check if the last json operation returned an error and convert it to an exception.
     * Designed as an internal method called after any json operation,
     * but there's no reason it can't be called after a straight call to the php json_* functions.
     */
    public static function checkLastError(): void
    {
        $error = json_last_error();

        if ($error == JSON_ERROR_NONE) {
            return;
        }

        $message = json_last_error_msg();

        throw new JsonException("JSON Error: " . $message, $error);
    }
}
