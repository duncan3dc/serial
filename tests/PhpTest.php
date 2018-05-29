<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Php;
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{

    public function testEncodeEmpty1()
    {
        $this->assertSame("", Php::encode(null));
    }
    public function testEncodeEmpty2()
    {
        $this->assertSame("", Php::encode([]));
    }
    public function testEncodeEmpty3()
    {
        $this->assertSame('i:0;', Php::encode(0));
    }
    public function testEncodeEmpty4()
    {
        $this->assertSame('s:0:"";', Php::encode(""));
    }


    public function testEncodeString1()
    {
        $this->assertSame('s:4:"test";', Php::encode("test"));
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
