<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\YamlException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

use function trim;

class Yaml extends AbstractSerial
{

    /**
     * Convert an array to a Yaml string.
     */
    public static function encode($array): string
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

        return SymfonyYaml::dump($array);
    }


    /**
     * Convert a yaml string to an array.
     */
    public static function decode(string $string): ArrayObject
    {
        if (trim($string) === "") {
            return new ArrayObject();
        }

        $array = SymfonyYaml::parse($string);

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }
}
