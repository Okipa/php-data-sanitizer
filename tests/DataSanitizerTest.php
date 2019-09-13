<?php

namespace Okipa\DataSanitizer\tests;

use Okipa\DataSanitizer\DataSanitizer;
use PHPUnit\Framework\TestCase;
use stdClass;

class DataSanitizerTest extends TestCase
{
    private $DataSanitizer;

    public function testSanitizeTrimmingString()
    {
        $this->assertEquals('test', $this->DataSanitizer->sanitize(' test '));
    }

    public function testSanitizeTransformsStringToBoolean()
    {
        $this->assertFalse($this->DataSanitizer->sanitize('false'));
        $this->assertTrue($this->DataSanitizer->sanitize('true'));
    }

    public function testSanitizeTransformsStringToNull()
    {
        $this->assertNull($this->DataSanitizer->sanitize('null'));
    }

    public function testSanitizeReturnsNullForNull()
    {
        $this->assertNull($this->DataSanitizer->sanitize(null));
    }

    public function testSanitizeReturnsNullForEmptyString()
    {
        $this->assertNull($this->DataSanitizer->sanitize(''));
    }

    public function testSanitizeTransformsStringToNumber()
    {
        $this->assertEquals(0, $this->DataSanitizer->sanitize('0'));
        $this->assertEquals(2.07, $this->DataSanitizer->sanitize('2.07'));
    }

    public function testSanitizeAcceptsDefaultParameter()
    {
        $this->assertEquals('robot', $this->DataSanitizer->sanitize(null, 'robot'));
        $this->assertEquals(57, $this->DataSanitizer->sanitize('', 57));
    }

    public function testSanitizeCanSanitizeAnArray()
    {
        $array = [
            'one'   => 'true',
            'two'   => 756,
            'three' => 'something',
            'four'  => 'false',
            'five'  => '',
            'six'   => null,
            'seven' => [
                'nested_one' => '',
                'nested_two' => '3',
            ],
        ];
        $sanitized = $this->DataSanitizer->sanitize($array);
        $this->assertTrue($sanitized['one']);
        $this->assertEquals(756, $sanitized['two']);
        $this->assertEquals('something', $sanitized['three']);
        $this->assertFalse($sanitized['four']);
        $this->assertNull($sanitized['five']);
        $this->assertNull($sanitized['six']);
        $this->assertTrue(is_array($sanitized['seven']));
        $this->assertNull($sanitized['seven']['nested_one']);
        $this->assertEquals(3, $sanitized['seven']['nested_two']);
    }

    public function testSanitizeDoesntChangeObjects()
    {
        $object = new stdClass;
        $object->one = 'true';
        $object->two = '756';
        $sanitized = $this->DataSanitizer->sanitize($object);
        $this->assertEquals('true', $sanitized->one);
        $this->assertEquals('756', $sanitized->two);
    }

    public function testSanitizeCanHandleJson()
    {
        $string = 'something';
        $this->assertEquals($string, $this->DataSanitizer->sanitize(json_encode($string)));
        $array = [
            'one' => true,
            'two' => null,
        ];
        $sanitized = $this->DataSanitizer->sanitize(json_encode($array));
        $this->assertEquals((object) $array, $sanitized);
    }

    public function testSanitizeCanHandleNestedJsonArray()
    {
        $array = [
            'one'    => 'true',
            'two'    => 756,
            'three'  => 'something',
            'four'   => 'false',
            'five'   => '',
            'six'    => null,
            'seven'  => [
                'nested_one' => '',
                'nested_two' => '3',
            ],
            'height' => ' test ',
        ];
        $sanitized = $this->DataSanitizer->sanitize(json_encode($array), null, true);
        $this->assertTrue(is_array($sanitized));
        $this->assertTrue($sanitized['one']);
        $this->assertEquals(756, $sanitized['two']);
        $this->assertEquals('something', $sanitized['three']);
        $this->assertFalse($sanitized['four']);
        $this->assertNull($sanitized['five']);
        $this->assertNull($sanitized['six']);
        $this->assertTrue(is_array($sanitized['seven']));
        $this->assertNull($sanitized['seven']['nested_one']);
        $this->assertEquals(3, $sanitized['seven']['nested_two']);
        $this->assertEquals('test', $sanitized['height']);
    }

    public function testSanitizeFloatInString()
    {
        $array = [
            'float_number'          => '3.14',
            'negative_float_number' => '-3.14',
        ];
        $sanitized = $this->DataSanitizer->sanitize(json_encode($array), null, true);
        $this->assertTrue(is_array($sanitized));
        $this->assertEquals(3.14, $sanitized['float_number']);
        $this->assertEquals(-3.14, $sanitized['negative_float_number']);
    }

    public function testSanitizeIntegerInString()
    {
        $array = [
            'integer_number'          => '3',
            'negative_integer_number' => '-3',
        ];
        $sanitized = $this->DataSanitizer->sanitize(json_encode($array), null, true);
        $this->assertTrue(is_array($sanitized));
        $this->assertEquals(3, $sanitized['integer_number']);
        $this->assertEquals(-3, $sanitized['negative_integer_number']);
    }

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->DataSanitizer = new DataSanitizer();
    }
}
