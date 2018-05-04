<?php

namespace Okipa\DataSanitizer\Native\Facades;

use Okipa\DataSanitizer\Native\DataSanitizerBootstrapper;

class DataSanitizer
{
    /**
     * The Native BootStrapper instance.
     *
     * @var DataSanitizerBootstrapper
     */
    protected static $instance;
    /**
     * The DataSanitizer instance.
     *
     * @var \Okipa\DataSanitizer\DataSanitizer
     */
    protected $DataSanitizer;

    /**
     * Constructor.
     *
     * @param DataSanitizerBootstrapper $bootstrapper
     */
    public function __construct(DataSanitizerBootstrapper $bootstrapper = null)
    {
        if ($bootstrapper === null) {
            $bootstrapper = new DataSanitizerBootstrapper;
        }

        $this->DataSanitizer = $bootstrapper->createDataSanitizer();
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::instance()->getDataSanitizer();
        switch (count($args)) {
            case 1:
                return $instance->{$method}($args[0]);

            case 2:
                return $instance->{$method}($args[0], $args[1]);

            case 3:
                return $instance->{$method}($args[0], $args[1], $args[2]);

            default:
                return call_user_func_array([$instance, $method], $args);
        }
    }

    /**
     * Creates a new Native Bootstrapper instance.
     *
     * @param DataSanitizerBootstrapper $bootstrapper
     *
     * @return \Okipa\DataSanitizer\Native\DataSanitizerBootstrapper
     */
    public static function instance(DataSanitizerBootstrapper $bootstrapper = null)
    {
        if (static::$instance === null) {
            static::$instance = new static($bootstrapper);
        }

        return static::$instance;
    }

    /**
     * Returns the DataSanitizer instance.
     *
     * @return \Okipa\DataSanitizer\DataSanitizer
     */
    public function getDataSanitizer()
    {
        return $this->DataSanitizer;
    }
}
