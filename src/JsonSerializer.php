<?php

namespace duncan3dc\Serial;

class JsonSerializer implements SerailizerInterface
{

    /**
     * Convert an array to a JSON string.
     *
     * {@inheritDoc}
     */
    public function encode(array $array)
    {
        $string = json_encode($array);

        Json::checkLastError();

        return $string;
    }


    /**
     * Convert a JSON string to an array.
     *
     * {@inheritDoc}
     */
    public function decode($string, $object)
    {
        $array = json_decode($string, !$object);

        Json::checkLastError();

        return $array;
    }
}
