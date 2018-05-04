<?php

namespace Okipa\DataSanitizer\tests\Native;

use Okipa\DataSanitizer\DataSanitizer;
use Okipa\DataSanitizer\Native\DataSanitizerBootstrapper;
use PHPUnit_Framework_TestCase;

class DataSanitizerBootstrapperTest extends PHPUnit_Framework_TestCase
{
    public function testIntantiate()
    {
        $bootstrapper = new DataSanitizerBootstrapper();

        $DataSanitizer = $bootstrapper->createDataSanitizer();

        $this->assertInstanceOf(DataSanitizer::class, $DataSanitizer);
    }
}
