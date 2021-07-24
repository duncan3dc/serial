<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Exceptions\InvalidArgumentException;
use duncan3dc\Serial\Exceptions\JsonException;
use duncan3dc\Serial\Json;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{


    public function testEncodeEmpty(): void
    {
        $this->assertSame("", Json::encode([]));
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
        Json::encode($value);
    }


    public function testEncodeInteger(): void
    {
        $this->assertSame('{"one":1}', Json::encode(["one" => 1]));
    }


    public function testEncodeString(): void
    {
        $this->assertSame('{"one":"1"}', Json::encode(["one" => "1"]));
    }


    public function testDecodeEmpty1(): void
    {
        $this->assertSame([], Json::decode("")->asArray());
    }
    public function testDecodeEmpty2(): void
    {
        $this->assertSame([], Json::decode("      ")->asArray());
    }


    public function testCheckLastErrorWithErrorMessage(): void
    {
        $this->expectException(JsonException::class);
        $this->expectExceptionMessage("JSON Error: Syntax error");
        Json::decode('{"one":}');
    }


    public function testDecodeInteger(): void
    {
        $this->assertSame(["one" => 1], Json::decode('{"one":1}')->asArray());
    }


    public function testDecodeString(): void
    {
        $this->assertSame(["one" => "1"], Json::decode('{"one":"1"}')->asArray());
    }
}
