<?php

namespace duncan3dc\Serial;

use duncan3dc\Serial\Exceptions\FileException;
use duncan3dc\Serial\Exceptions\InvalidArgumentException;

use function is_array;

abstract class AbstractSerial implements SerialInterface
{


    /**
     * Ensure the passed data is a basic array.
     *
     * @param mixed $data The array-like structure to convert
     *
     * @return array<int|string,mixed>
     */
    protected static function asArray($data): array
    {
        if ($data instanceof ArrayObject) {
            return $data->asArray();
        }

        if (!is_array($data)) {
            throw new InvalidArgumentException("Only arrays or ArrayObjects can be encoded");
        }

        return $data;
    }



    public static function encodeToFile(string $path, $array): void
    {
        $string = static::encode($array);

        # Ensure the directory exists
        $directory = pathinfo($path, PATHINFO_DIRNAME);
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        if (file_put_contents($path, $string) === false) {
            throw new FileException("Failed to write the file: {$path}");
        }
    }


    public static function decodeFromFile(string $path): ArrayObject
    {
        if (!is_file($path)) {
            throw new FileException("File does not exist: {$path}");
        }

        $string = file_get_contents($path);

        if ($string === false) {
            throw new FileException("Failed to read the file: {$path}");
        }

        return static::decode($string);
    }
}
