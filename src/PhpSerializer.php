<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\PhpException;

class PhpSerializer implements SerailizerInterface
{

    /**
     * Convert an array to a php serialized string.
     *
     * {@inheritDoc}
     */
    public function encode(array $array)
    {
        try {
            $string = serialize($array);
        } catch (\Exception $e) {
            throw new PhpException("Serialize Error: " . $e->getMessage());
        }

        return $string;
    }


    /**
     * Convert a php serialized string to an array.
     *
     * {@inheritDoc}
     */
    public static function decode($string, $object)
    {
        try {
            $array = unserialize($string);
        } catch (\Exception $e) {
            throw new PhpException("Serialize Error: " . $e->getMessage());
        }

        if ($object) {
            $array = json_decode(json_encode($array));
        }

        return $array;
    }
}
