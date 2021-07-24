<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Php;
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{


    public function testEncodeEmpty(): void
    {
        $this->assertSame("", Php::encode([]));
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
        Php::encode($value);
    }


    public function testEncodeArray1(): void
    {
        $this->assertSame('a:1:{s:3:"one";i:1;}', Php::encode(["one" => 1]));
    }
    public function testEncodeArray2(): void
    {
        $this->assertSame('a:1:{s:3:"one";s:1:"1";}', Php::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1(): void
    {
        $this->assertSame([], Php::decode("")->asArray());
    }
    public function testDecodeEmpty2(): void
    {
        $this->assertSame([], Php::decode("     ")->asArray());
    }


    public function testDecodeString1(): void
    {
        $this->assertSame([], Php::decode('s:4:"test";')->asArray());
    }


    public function testDecodeArray1(): void
    {
        $this->assertSame(["one" => 1], Php::decode('a:1:{s:3:"one";i:1;}')->asArray());
    }
    public function testDecodeArray2(): void
    {
        $this->assertSame(["one" => "1"], Php::decode('a:1:{s:3:"one";s:1:"1";}')->asArray());
    }
}
