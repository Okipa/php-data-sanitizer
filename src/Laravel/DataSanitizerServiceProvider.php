<?php

namespace Okipa\DataSanitizer\Laravel;

use Illuminate\Support\ServiceProvider;
use Okipa\DataSanitizer\DataSanitizer;

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
