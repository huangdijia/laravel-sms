<?php

namespace Huangdijia\Sms\Facades;

use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sms';
    }
}
