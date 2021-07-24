<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Yaml;
use PHPUnit\Framework\TestCase;

class YamlTest extends TestCase
{

    public function testEncodeEmpty(): void
    {
        $this->assertSame("", Yaml::encode([]));
    }


    /**
     * @return iterable<mixed>
     */
    public function invalidValueProvider(): iterable
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
     * @param mixed $value
     */
    public function testEncodeInvalidValue($value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Only arrays or ArrayObjects can be encoded");
        Yaml::encode($value);
    }


    public function testEncodeArray1(): void
    {
        $this->assertSame("one: 1\n", Yaml::encode(["one" => 1]));
    }
    public function testEncodeArray2(): void
    {
        $this->assertSame("one: '1'\n", Yaml::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1(): void
    {
        $this->assertSame([], Yaml::decode("")->asArray());
    }
    public function testDecodeEmpty2(): void
    {
        $this->assertSame([], Yaml::decode("    ")->asArray());
    }


    public function testDecodeString1(): void
    {
        $this->assertSame([], Yaml::decode('"test"')->asArray());
    }


    public function testDecodeArray1(): void
    {
        $this->assertSame(["one" => 1], Yaml::decode("one: 1")->asArray());
    }
    public function testDecodeArray2(): void
    {
        $this->assertSame(["one" => "1"], Yaml::decode("one: '1'")->asArray());
    }
}
