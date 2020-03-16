<?php

namespace Huangdijia\Sms\Drivers;

use Huangdijia\Sms\Contracts\Driver;

class Local implements Driver
{
    /**
     * Send
     * @param mixed $to 
     * @param mixed $content 
     * @return null 
     */
    public function send(string $to, string $content)
    {
        return null;
    }

    /**
     * Get the info of account
     * @return array 
     */
    public function info()
    {
        return [];
    }
}