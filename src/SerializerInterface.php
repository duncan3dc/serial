<?php

namespace duncan3dc\Serial;

interface SerializerInterface
{

    /**
     * Convert an array to a serialized string.
     *
     * @param array The data to encode
     *
     * @return string
     */
    public function encode(array $array);


    /**
     * Convert a serialized string to an array.
     *
     * @param string $string The data to decode
     * @param bool $object Whether the result should be returned as an object
     *
     * @return array|object
     */
    public function decode($string, $object);
}
