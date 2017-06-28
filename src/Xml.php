<?php

namespace duncan3dc\Serial;

use duncan3dc\DomParser\XmlBase;
use duncan3dc\DomParser\XmlParser;
use duncan3dc\DomParser\XmlWriter;
use duncan3dc\Serial\Exceptions\XmlException;

class Xml extends AbstractSerial
{

    /**
     * Convert an array to a xml string.
     *
     * {@inheritDoc}
     */
    public static function encode($array)
    {
        if (count($array) < 1) {
            return "";
        }

        return XmlWriter::createXml($array);
    }


    /**
     * Convert a xml string to an array.
     *
     * {@inheritDoc}
     */
    public static function decode($string)
    {
        if (!$string) {
            return [];
        }

        $parser = new XmlParser($string);
        $array = static::getTags($parser);

        return $array;
    }


    protected static function getTags($element)
    {
        $array = [];

        foreach ($element->childNodes as $tag) {
            if ($tag->hasChildNodes()) {
                $array[$tag->tagName] = static::getTags($tag);
            } else {
                $array[$tag->tagName] = $tag->nodeValue;
            }
        }

        return $array;
    }
}
