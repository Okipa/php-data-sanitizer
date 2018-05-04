<?php

namespace Okipa\DataSanitizer\Laravel;

use Okipa\DataSanitizer\DataSanitizer;
use Illuminate\Support\ServiceProvider;

class DataSanitizerServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerDataSanitizer();
    }

    /**
     * Registers input sanitizer.
     *
     * @return void
     */
    protected function registerDataSanitizer()
    {
        $this->app->singleton('data_sanitizer', function () {
            return new DataSanitizer();
        });
    }
}
