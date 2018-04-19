<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Ini;
use PHPUnit\Framework\TestCase;

class IniTest extends TestCase
{

    public function testEncodeEmpty()
    {
        $this->assertSame("", Ini::encode([]));
    }


    public function testEncodeInteger()
    {
        $this->assertSame("one = 1\n", Ini::encode(["one" => 1]));
    }


    public function testEncodeString()
    {
        $this->assertSame("one = '1'\n", Ini::encode(["one" => "1"]));
    }


    public function testDecodeEmpty()
    {
        $this->assertSame([], Ini::decode("")->asArray());
    }


    public function testDecodeInteger()
    {
        $this->assertSame(["one" => 1], Ini::decode("one = 1")->asArray());
    }


    public function testDecodeString()
    {
        $this->assertSame(["one" => "1"], Ini::decode("one = '1'")->asArray());
    }
}
