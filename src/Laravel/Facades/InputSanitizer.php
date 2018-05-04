<?php

namespace Okipa\DataSanitizer\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class DataSanitizer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'input_sanitizer';
    }
}
