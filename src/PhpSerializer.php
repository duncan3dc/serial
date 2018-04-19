<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\PhpException;

class PhpSerializer extends AbstractSerializer
{

    /**
     * Convert an array to a php serialized string.
     *
     * {@inheritDoc}
     */
    public function encode($array)
    {
        $array = $this->asArray($array);

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
     *
     * {@inheritDoc}
     */
    public function decode($string)
    {
        if (!$string) {
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
