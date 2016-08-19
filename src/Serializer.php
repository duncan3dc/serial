<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\FileException;

class Serializer
{
    private $serializer;


    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * Convert an array to a JSON string.
     *
     * {@inheritDoc}
     */
    public function encode($array)
    {
        if ($array instanceof ArrayObject) {
            $array = $array->asArray();
        }

        return $this->serializer->encode($array);
    }


    /**
     * Convert a JSON string to an array.
     *
     * {@inheritDoc}
     */
    public function decode($string)
    {
        $array = $this->decodeArray($string);

        if (!is_array($array)) {
            $array = [];
        }

        return ArrayObject::make($array);
    }


    /**
     * Convert an array to a serial string, and then write it to a file.
     *
     * {@inheritDoc}
     */
    public function encodeToFile($path, $array)
    {
        $string = $this->encode($array);

        # Ensure the directory exists
        $directory = pathinfo($path, PATHINFO_DIRNAME);
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        if (file_put_contents($path, $string) === false) {
            throw new FileException("Failed to write the file: {$path}");
        }
    }


    /**
     * Read a serial string from a file and convert it to an array.
     *
     * {@inheritDoc}
     */
    public function decodeFromFile($path)
    {
        if (!is_file($path)) {
            throw new FileException("File does not exist: {$path}");
        }

        $string = file_get_contents($path);

        if ($string === false) {
            throw new FileException("Failed to read the file: {$path}");
        }

        return $this->decode($string);
    }


    /**
     * Convert a JSON string to an array.
     *
     * {@inheritDoc}
     */
    public function decodeObject($string)
    {
        if (!$string) {
            return (object) [];
        }

        $object = $this->serializer->decode($string, true);

        if (is_array($object)) {
            $object = (object) $object;
        }

        return $object;
    }


    /**
     * Convert a JSON string to an array.
     *
     * {@inheritDoc}
     */
    public function decodeArray($string)
    {
        if (!$string) {
            return [];
        }

        return $this->serializer->decode($string);
    }
}
