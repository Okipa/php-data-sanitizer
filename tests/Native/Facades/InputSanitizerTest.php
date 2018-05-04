<?php

/**
 * Part of the DataSanitizer package.
 *
 * @package    DataSanitizer
 * @version    1.0.2
 * @author     Arthur Lorent <arthur.lorent@gmail.com>, Daniel Lucas <daniel.chris.lucas@gmail.com>
 * @license    MIT
 * @copyright  (c) 2006-2017, ACID-Solutions SARL
 * @link       https://acid.fr
 */

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
        $this->assertInstanceOf(\Okipa\DataSanitizer\Native\Facades\DataSanitizer::class, $facade->instance());
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
