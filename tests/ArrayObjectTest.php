<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\ArrayObject;
use PHPUnit\Framework\TestCase;

class ArrayObjectTest extends TestCase
{


    public function testSimpleField(): void
    {
        $test = ArrayObject::make([
            "field1"    =>  "one",
        ]);
        $this->assertSame("one", $test->field1);
        $this->assertSame("one", $test["field1"]);
    }


    public function testMutliDimensional(): void
    {
        $test = ArrayObject::make([
            "data"    =>  [
                "field2"    =>  77,
            ],
        ]);
        $this->assertSame(77, $test->data->field2);
        $this->assertSame(77, $test["data"]["field2"]);
    }


    public function testNumericallyIndexed(): void
    {
        $test = ArrayObject::make([
            "value1",
            2,
            "three",
            false,
        ]);
        $this->assertSame("value1", $test[0]);
        $this->assertSame("value1", $test->{0});
        $this->assertSame(2, $test[1]);
        $this->assertSame(2, $test->{1});
        $this->assertSame("three", $test[2]);
        $this->assertSame("three", $test->{2});
        $this->assertSame(false, $test[3]);
        $this->assertSame(false, $test->{3});
    }


    public function testForeach(): void
    {
        $values = [
            "value1",
            2,
            "three",
            false,
        ];
        $test = ArrayObject::make($values);

        $result = [];
        foreach ($test as $key => $val) {
            $result[$key] = $val;
        }

        $this->assertSame($values, $result);
    }


    public function testCount(): void
    {
        $test = ArrayObject::make([
            "value1",
            2,
            "three",
            false,
        ]);

        $this->assertSame(4, count($test));
    }


    public function testCountZero(): void
    {
        $test = ArrayObject::make([]);

        $this->assertSame(0, count($test));
    }


    public function testIsset(): void
    {
        $test = ArrayObject::make([
            "field1"    =>  "value1",
        ]);

        $this->assertTrue(isset($test->field1));
        $this->assertTrue(isset($test["field1"]));

        $this->assertFalse(isset($test->field2));
        $this->assertFalse(isset($test["field2"]));
    }


    public function testAsArray(): void
    {
        $data = [
            "one"   =>  1,
            "two"   =>  2,
            "extra" =>  [
                "fields"    =>  ["field1", "field2", "field3"],
                "value"     =>  true,
            ],
        ];
        $this->assertSame($data, ArrayObject::make($data)->asArray());
    }


    public function testAsJson(): void
    {
        $data = ["one" => 1, "two" => 2];
        $this->assertSame('{"one":1,"two":2}', ArrayObject::make($data)->asJson());
    }


    public function testAsPhp(): void
    {
        $data = ["one" => 1, "two" => 2];
        $this->assertSame('a:2:{s:3:"one";i:1;s:3:"two";i:2;}', ArrayObject::make($data)->asPhp());
    }


    public function testAsYaml(): void
    {
        $data = ["one" => 1, "two" => 2];
        $this->assertSame("one: 1\ntwo: 2\n", ArrayObject::make($data)->asYaml());
    }
}
