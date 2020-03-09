<?php

namespace Huangdijia\Sms;

use Closure;
use InvalidArgumentException;

/**
 * @method public static self to(string $to)
 * @method public static self content(string $content)
 * @method public static self withRules(array $rules, array $messages)
 * @method public static \Huangdijia\Sms\Response send()
 * @method public static array info()
 * @package Huangdijia\Sms
 */
class SmsManager
{
    protected $app;
    protected $drivers       = [];
    protected $customDrivers = [];
    protected $default;

    /**
     * Construct
     * @param mixed $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Set default driver
     * @param string $name 
     * @return void 
     */
    function default(string $name) {
        $this->default = $name;
    }

    /**
     * Register a custom driver
     * @param string $name 
     * @param Closure $callback 
     * @return void 
     */
    public function register(string $name, Closure $callback)
    {
        $this->customDrivers[$name] = $callback($this->app);
    }

    /**
     * Resolve a instance
     * @param string|null $name 
     * @return mixed|Sms 
     * @throws InvalidArgumentException 
     */
    public function driver(string $name = null)
    {
        $name = $name ?? $this->getDefaultDriver();

        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Get all drivers
     * @return array 
     */
    public function drivers()
    {
        return $this->drivers;
    }

    /**
     * Get all custom drivers
     * @return array 
     */
    public function getCustomDrivers()
    {
        return $this->customDrivers;
    }

    /**
     * Resolve a instance
     * @param mixed $name 
     * @return Sms 
     * @throws InvalidArgumentException 
     */
    public function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Sms driver [{$name}] is not defined.");
        }

        if (isset($this->customDrivers[$name])) {
            return new Sms($this->customDrivers[$name]);
        }

        return new Sms($this->createDriver($config));
    }

    /**
     * Create a driver
     * @param array $config 
     * @return object 
     * @throws InvalidArgumentException 
     */
    public function createDriver(array $config)
    {
        if (empty($config['driver']) || !class_exists($config['driver'])) {
            throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
        }

        return new $config['driver']($config);
    }

    /**
     * Get config by driver name
     * @param string $name 
     * @return mixed 
     */
    public function getConfig(string $name)
    {
        return $this->app['config']["sms.drivers.{$name}"];
    }

    /**
     * Get default driver name
     * @return string|mixed 
     */
    public function getDefaultDriver()
    {
        return $this->default ?? $this->app['config']['sms.default'];
    }

    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
