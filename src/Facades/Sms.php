<?php

namespace Huangdijia\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void __construct($app)
 * @method static void register(string $name, Closure $callback)
 * @method static \Huangdijia\Sms\Sms use(string $name = null)
 * @method static \Huangdijia\Sms\Sms driver(string $name = null)
 * @method static \Huangdijia\Sms\Sms[] drivers()
 * @method static array getCustomDrivers()
 * @method static \Huangdijia\Sms\Sms resolve($name)
 * @method static \Huangdijia\Sms\Contracts\Driver  createDriver(array $config)
 * @method static array getConfig(string $name)
 * @method static string getDefaultDriver()
 * @method static static to(string $to)
 * @method static static content(string $content)
 * @method static static withRules(array $rules, array $messages)
 * @method static \Huangdijia\Sms\Response send()
 * @method static array info()
 * @package Huangdijia\Sms
 */
class Sms extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sms';
    }
}
