<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Yaml;
use PHPUnit\Framework\TestCase;

class YamlTest extends TestCase
{

    public function testEncodeEmpty()
    {
        $this->assertSame("", Yaml::encode([]));
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
        Yaml::encode($value);
    }


    public function testEncodeArray1()
    {
        $this->assertSame("one: 1\n", Yaml::encode(["one" => 1]));
    }
    public function testEncodeArray2()
    {
        $this->assertSame("one: '1'\n", Yaml::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1()
    {
        $this->assertSame([], Yaml::decode(null)->asArray());
    }
    public function testDecodeEmpty2()
    {
        $this->assertSame([], Yaml::decode("")->asArray());
    }
    public function testDecodeEmpty3()
    {
        $this->assertSame([], Yaml::decode(0)->asArray());
    }
    public function testDecodeEmpty4()
    {
        $this->assertSame([], Yaml::decode("0")->asArray());
    }


    public function testDecodeString1()
    {
        $this->assertSame([], Yaml::decode('"test"')->asArray());
    }


    public function testDecodeArray1()
    {
        $this->assertSame(["one" => 1], Yaml::decode("one: 1")->asArray());
    }
    public function testDecodeArray2()
    {
        $this->assertSame(["one" => "1"], Yaml::decode("one: '1'")->asArray());
    }
}
