<?php

namespace Okipa\DataSanitizer\tests\Native;

use Okipa\DataSanitizer\DataSanitizer;
use Okipa\DataSanitizer\Native\DataSanitizerBootstrapper;
use PHPUnit\Framework\TestCase;

class DataSanitizerBootstrapperTest extends TestCase
{
    public function testInstantiate()
    {
        $bootstrapper = new DataSanitizerBootstrapper();
        $DataSanitizer = $bootstrapper->createDataSanitizer();
        $this->assertInstanceOf(DataSanitizer::class, $DataSanitizer);
    }
}
