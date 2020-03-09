<?php

namespace Huangdijia\Sms\Drivers;

use Huangdijia\Sms\Contracts\Driver;

class Local implements Driver
{
    /**
     * Get config
     * @return array 
     */
    public function getConfig()
    {
        return [];
    }

    /**
     * Send
     * @param mixed $to 
     * @param mixed $content 
     * @return true 
     */
    public function send(string $to, string $content)
    {
        return true;
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