<?php

namespace Okipa\DataSanitizer\tests\Native\Facades;

use Okipa\DataSanitizer\Native\Facades\DataSanitizer;
use Okipa\DataSanitizer\Native\DataSanitizerBootstrapper;
use PHPUnit_Framework_TestCase;

class DataSanitizerBootstrapperTest extends PHPUnit_Framework_TestCase
{
    public function testIntantiate()
    {
        $facade = new DataSanitizer();
        $this->assertInstanceOf(\Okipa\DataSanitizer\DataSanitizer::class, $facade->getDataSanitizer());
    }

    public function testInstantiateWithBootstrapper()
    {
        $bootStrapper = new DataSanitizerBootstrapper();
        $facade = new DataSanitizer($bootStrapper);
        $this->assertInstanceOf(\Okipa\DataSanitizer\DataSanitizer::class, $facade->getDataSanitizer());
    }

    public function testGetInstance()
    {
        $facade = new DataSanitizer();
        $this->assertInstanceOf(DataSanitizer::class, $facade->instance());
    }

    public function testCallMethods()
    {
        $facade = new DataSanitizer();

        $this->assertTrue($facade::sanitize('true'));
        $this->assertTrue($facade::sanitize(null, true));
        $this->assertTrue($facade::sanitize(null, true, true));
        $this->assertTrue($facade::sanitize(null, true, true, 'extra_param'));
    }
}
