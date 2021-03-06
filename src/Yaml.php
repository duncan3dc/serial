<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\YamlException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml extends AbstractSerial
{

    /**
     * Convert an array to a Yaml string.
     *
     * {@inheritDoc}
     */
    public static function encode($array)
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

        return SymfonyYaml::dump($array);
    }


    /**
     * Convert a yaml string to an array.
     *
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        if (!$string) {
            return new ArrayObject();
        }

        $array = SymfonyYaml::parse($string);

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }
}
