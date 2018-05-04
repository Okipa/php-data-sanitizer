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

namespace Okipa\DataSanitizer\tests\Native;

use Okipa\DataSanitizer\Native\DataSanitizerBootstrapper;
use PHPUnit_Framework_TestCase;

class DataSanitizerBootstrapperTest extends PHPUnit_Framework_TestCase
{
    public function testIntantiate()
    {
        $bootstrapper = new DataSanitizerBootstrapper();

        $DataSanitizer = $bootstrapper->createDataSanitizer();

        $this->assertInstanceOf(\Okipa\DataSanitizer\DataSanitizer::class, $DataSanitizer);
    }
}
