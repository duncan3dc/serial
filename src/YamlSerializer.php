<?php

namespace duncan3dc\Serial;

use Symfony\Component\Yaml\Yaml;

class YamlSerializer implements SerailizerInterface
{

    /**
     * Convert an array to a Yaml string.
     *
     * {@inheritDoc}
     */
    public function encode(array $array)
    {
        return Yaml::dump($array);
    }


    /**
     * Convert a yaml string to an array.
     *
     * {@inheritDoc}
     */
    public function decode($string, $object)
    {
        if ($object) {
            $flags = Yaml::PARSE_OBJECT;
        } else {
            $flags = 0;
        }

        return Yaml::parse($string, $flags);
    }
}
