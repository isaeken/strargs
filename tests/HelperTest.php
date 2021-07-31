<?php

namespace IsaEken\Strargs\Tests;

use IsaEken\Strargs\Helpers;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testIsJson()
    {
        $jsons = [
            "[1,2,3]",
            "{\"key\": \"value\"}",
        ];

        $notJsons = [
            "",
            "testing",
            "{]",
        ];

        foreach ($jsons as $string) {
            $this->assertTrue(Helpers::isJson($string));
        }

        foreach ($notJsons as $string) {
            $this->assertFalse(Helpers::isJson($string));
        }
    }

    public function testStringToValue()
    {
        $this->assertEquals([1,2], Helpers::stringToValue('"[1,2]"'));
        $this->assertEquals((object) ['key' => 'value'], Helpers::stringToValue('"{\"key\": \"value\"}"'));
        $this->assertEquals('string', Helpers::stringToValue('string'));
        $this->assertEquals('string', Helpers::stringToValue('"string"'));
        $this->assertEquals(1, Helpers::stringToValue('1'));
        $this->assertEquals(2, Helpers::stringToValue('2'));
        $this->assertEquals(3.3, Helpers::stringToValue('3.3'));
        $this->assertEquals(4.4, Helpers::stringToValue('4.4'));
        $this->assertEquals(true, Helpers::stringToValue('true'));
        $this->assertEquals(false, Helpers::stringToValue('false'));
        $this->assertEquals(null, Helpers::stringToValue('null'));
    }

    public function testValueToString()
    {
        $this->assertEquals('"[1,2]"', Helpers::valueToString([1,2]));
        $this->assertEquals('"{\"key\":\"value\"}"', Helpers::valueToString((object) ['key' => 'value']));
        $this->assertEquals('"string"', Helpers::valueToString('string'));
        $this->assertEquals('1', Helpers::valueToString(1));
        $this->assertEquals('2', Helpers::valueToString(2));
        $this->assertEquals('3.3', Helpers::valueToString(3.3));
        $this->assertEquals('4.4', Helpers::valueToString(4.4));
        $this->assertEquals('true', Helpers::valueToString(true));
        $this->assertEquals('false', Helpers::valueToString(false));
        $this->assertEquals('null', Helpers::valueToString(null));
    }
}
