<?php

namespace duncan3dc\SerialTests;

use duncan3dc\Serial\Json;

class PerformanceTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $row = [
            "cono"  =>  "RP",
            "ordn"  =>  "1234567",
            "date"  =>  1160405,
            "time"  =>  160457,
        ];

        for ($i = 0; $i < 99; ++$i) {
            Json::encodeToFile("/tmp/cache/{$i}.json", $row);

            $result = Json::decodeFromFile("/tmp/cache/{$i}.json");

            if (is_object($result)) {
                $result = $result->asArray();
            }

            $this->assertSame($row, $result);
        }
    }
}
