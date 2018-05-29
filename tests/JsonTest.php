<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Json;
use duncan3dc\Serial\Exceptions\JsonException;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{

    public function testEncodeEmpty1()
    {
        $this->assertSame("", Json::encode(null));
    }
    public function testEncodeEmpty2()
    {
        $this->assertSame("", Json::encode([]));
    }
    public function testEncodeEmpty3()
    {
        $this->assertSame("0", Json::encode(0));
    }
    public function testEncodeEmpty4()
    {
        $this->assertSame('""', Json::encode(""));
    }


    public function testEncodeString1()
    {
        $this->assertSame('"test"', Json::encode("test"));
    }


    public function testEncodeArray1()
    {
        $this->assertSame('{"one":1}', Json::encode(["one" => 1]));
    }
    public function testEncodeArray2()
    {
        $this->assertSame('{"one":"1"}', Json::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1()
    {
        $this->assertSame([], Json::decode(null)->asArray());
    }
    public function testDecodeEmpty2()
    {
        $this->assertSame([], Json::decode("")->asArray());
    }
    public function testDecodeEmpty3()
    {
        $this->assertSame([], Json::decode(0)->asArray());
    }
    public function testDecodeEmpty4()
    {
        $this->assertSame([], Json::decode("0")->asArray());
    }


    public function testDecodeString1()
    {
        $this->assertSame([], Json::decode('"test"')->asArray());
    }


    public function testCheckLastErrorWithErrorMessage()
    {
        $this->expectException(JsonException::class);
        $this->expectExceptionMessage("JSON Error: Syntax error");
        Json::decode('{"one":}');
    }


    public function testDecodeArray1()
    {
        $this->assertSame(["one" => 1], Json::decode('{"one":1}')->asArray());
    }
    public function testDecodeArray2()
    {
        $this->assertSame(["one" => "1"], Json::decode('{"one":"1"}')->asArray());
    }
}
