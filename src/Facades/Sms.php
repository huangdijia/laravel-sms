<?php

namespace Huangdijia\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method staitc void __construct($app)
 * @method staitc void register(string $name, Closure $callback)
 * @method staitc \Huangdijia\Sms\Sms use(string $name = null)
 * @method staitc \Huangdijia\Sms\Sms driver(string $name = null)
 * @method staitc \Huangdijia\Sms\Sms[] drivers()
 * @method staitc array getCustomDrivers()
 * @method staitc \Huangdijia\Sms\Sms resolve($name)
 * @method staitc \Huangdijia\Sms\Contracts\Driver  createDriver(array $config)
 * @method staitc array getConfig(string $name)
 * @method staitc string getDefaultDriver()
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
