<?php

namespace duncan3dc\Serial;

/**
 * Allow both object/property and array/key access to data.
 * @template-extends \ArrayObject<int|string,mixed>
 */
class ArrayObject extends \ArrayObject
{

    /**
     * Create a new instance from a basic array.
     *
     * @param array<int|string,mixed> $data The array to convert
     */
    public static function make(array $data): self
    {
        # Convert values to ArrayObject instances
        foreach ($data as &$value) {
            if (is_array($value)) {
                $value = static::make($value);
            }
        }
        unset($value);

        return new self($data, \ArrayObject::ARRAY_AS_PROPS);
    }


    /**
     * Convert the current instance to a basic array.
     *
     * @return array<int|string,mixed>
     */
    public function asArray(): array
    {
        $array = [];

        foreach ($this as $key => $val) {
            if ($val instanceof self) {
                $val = $val->asArray();
            }
            $array[$key] = $val;
        }

        return $array;
    }


    /**
     * Serialize this instance as JSON.
     *
     * @return string
     */
    public function asJson(): string
    {
        return Json::encode($this);
    }


    /**
     * Serialize this instance as PHP.
     *
     * @return string
     */
    public function asPhp(): string
    {
        return Php::encode($this);
    }


    /**
     * Serialize this instance as YAML.
     *
     * @return string
     */
    public function asYaml(): string
    {
        return Yaml::encode($this);
    }
}
