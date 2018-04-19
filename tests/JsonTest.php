<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Json;
use duncan3dc\Serial\Exceptions\JsonException;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{

    public function testEncodeEmpty()
    {
        $this->assertSame("", Json::encode([]));
    }


    public function invalidValueProvider()
    {
        $values = [
            null,
            0,
            "",
            "test",
        ];
        foreach ($values as $value) {
            yield [$value];
        }
    }
    /**
     * @dataProvider invalidValueProvider
     */
    public function testEncodeInvalidValue($value)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Only arrays or ArrayObjects can be encoded");
        Json::encode($value);
    }


    public function testEncodeInteger()
    {
        $this->assertSame('{"one":1}', Json::encode(["one" => 1]));
    }


    public function testEncodeString()
    {
        $this->assertSame('{"one":"1"}', Json::encode(["one" => "1"]));
    }


    public function testDecodeEmpty()
    {
        $this->assertSame([], Json::decode("")->asArray());
    }


    public function testCheckLastErrorWithErrorMessage()
    {
        $this->expectException(JsonException::class);
        $this->expectExceptionMessage("JSON Error: Syntax error");
        Json::decode('{"one":}');
    }


    public function testDecodeInteger()
    {
        $this->assertSame(["one" => 1], Json::decode('{"one":1}')->asArray());
    }


    public function testDecodeString()
    {
        $this->assertSame(["one" => "1"], Json::decode('{"one":"1"}')->asArray());
    }
}
