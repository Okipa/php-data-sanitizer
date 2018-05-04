<?php

namespace Okipa\DataSanitizer\tests;

use Okipa\DataSanitizer\DataSanitizer;
use PHPUnit_Framework_TestCase;
use stdClass;

class DataSanitizerTest extends PHPUnit_Framework_TestCase
{
    private $DataSanitizer;

    public function setUp()
    {
        $this->DataSanitizer = new DataSanitizer();
    }

    /**
     * Test sanitize returns boolean false for string 'false'
     */
    public function testSanitizeTransformsStringToBoolean()
    {
        $this->assertFalse($this->DataSanitizer->sanitize('false'));
        $this->assertTrue($this->DataSanitizer->sanitize('true'));
    }

    /**
     * Test sanitize returns type null for string 'null'
     */
    public function testSanitizeTransformsStringToNull()
    {
        $this->assertNull($this->DataSanitizer->sanitize('null'));
    }

    /**
     * Test sanitize returns type null when given null
     */
    public function testSanitizeReturnsNullForNull()
    {
        $this->assertNull($this->DataSanitizer->sanitize(null));
    }

    /**
     * Test sanitize returns null for an empty string
     */
    public function testSanitizeReturnsNullForEmptyString()
    {
        $this->assertNull($this->DataSanitizer->sanitize(''));
    }

    /**
     * Test sanitize returns a number when given a number as a string
     */
    public function testSanitizeTransformsStringToNumber()
    {
        $this->assertEquals(0, $this->DataSanitizer->sanitize('0'));
        $this->assertEquals(2.07, $this->DataSanitizer->sanitize('2.07'));
    }

    /**
     * Test sanitize accepts a default parameter which overrides falsy values.
     */
    public function testSanitizeAcceptsDefaultParameter()
    {
        $this->assertEquals('robot', $this->DataSanitizer->sanitize(null, 'robot'));
        $this->assertEquals(57, $this->DataSanitizer->sanitize('', 57));
    }

    /**
     * Test sanitize can handle arrays
     */
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
                'nested_two' => '3'
            ]
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

    /**
     * Test sanitize can handle objects
     */
    public function testSanitizeDoesntChangeObjects()
    {
        $object = new stdClass;
        $object->one = 'true';
        $object->two = '756';

        $sanitized = $this->DataSanitizer->sanitize($object);

        $this->assertEquals('true', $sanitized->one);
        $this->assertEquals('756', $sanitized->two);
    }

    /**
     * Test sanitize can handle JSON
     */
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

    /**
     * Test sanitize can handle a nested JSON array
     */
    public function testSanitizeCanHandleNestedJsonArray()
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
                'nested_two' => '3'
            ]
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
    }
}
