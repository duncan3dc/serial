<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\TomlException;
use Yosymfony\Toml\Toml as YosymfonyToml;
use Yosymfony\Toml\TomlBuilder;

class Toml extends AbstractSerial
{

    /**
     * Convert an array to a toml string.
     *
     * {@inheritDoc}
     */
    public static function encode($array)
    {
        $array = static::asArray($array);

        if (is_array($array) && count($array) < 1) {
            return "";
        }

# @todo
        return (new TomlBuilder)::dump($array);
    }


    /**
     * Convert a toml string to an array.
     *
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        if (!$string) {
            return new ArrayObject;
        }

        $array = YosymfonyToml::Parse($string);

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }
}
