<?php

namespace Okipa\DataSanitizer\Native;

use Okipa\DataSanitizer\DataSanitizer;

class DataSanitizerBootstrapper
{
    /**
     * Creates an DataSanitizer instance.
     *
     * @return \Okipa\DataSanitizer\DataSanitizer
     */
    public function createDataSanitizer()
    {
        return new DataSanitizer();
    }
}
