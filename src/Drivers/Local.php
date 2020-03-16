<?php

namespace Huangdijia\Sms\Drivers;

use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Response as Resp;

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
        return new Response(new Resp(''));
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
