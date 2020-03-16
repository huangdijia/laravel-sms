<?php

namespace Huangdijia\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method public staitc __construct($app)
 * @method public staitc register(string $name, Closure $callback)
 * @method public staitc use(string $name = null)
 * @method public staitc driver(string $name = null)
 * @method public staitc drivers()
 * @method public staitc getCustomDrivers()
 * @method public staitc resolve($name)
 * @method public staitc createDriver(array $config)
 * @method public staitc getConfig(string $name)
 * @method public staitc getDefaultDriver()
 * @method public static self to(string $to)
 * @method public static self content(string $content)
 * @method public static self withRules(array $rules, array $messages)
 * @method public static \Huangdijia\Sms\Response send()
 * @method public static array info()
 * @package Huangdijia\Sms
 */
class Sms extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sms';
    }
}
