<?php

namespace Okipa\DataSanitizer\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class DataSanitizer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'input_sanitizer';
    }
}
