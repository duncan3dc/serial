<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Php;
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{

    public function testEncodeEmpty()
    {
        $this->assertSame("", Php::encode([]));
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
        Php::encode($value);
    }


    public function testEncodeArray1()
    {
        $this->assertSame('a:1:{s:3:"one";i:1;}', Php::encode(["one" => 1]));
    }
    public function testEncodeArray2()
    {
        $this->assertSame('a:1:{s:3:"one";s:1:"1";}', Php::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1()
    {
        $this->assertSame([], Php::decode(null)->asArray());
    }
    public function testDecodeEmpty2()
    {
        $this->assertSame([], Php::decode("")->asArray());
    }
    public function testDecodeEmpty3()
    {
        $this->assertSame([], Php::decode(0)->asArray());
    }
    public function testDecodeEmpty4()
    {
        $this->assertSame([], Php::decode("0")->asArray());
    }


    public function testDecodeString1()
    {
        $this->assertSame([], Php::decode('s:4:"test";')->asArray());
    }


    public function testDecodeArray1()
    {
        $this->assertSame(["one" => 1], Php::decode('a:1:{s:3:"one";i:1;}')->asArray());
    }
    public function testDecodeArray2()
    {
        $this->assertSame(["one" => "1"], Php::decode('a:1:{s:3:"one";s:1:"1";}')->asArray());
    }
}
