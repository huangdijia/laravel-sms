<?php

namespace Huangdijia\Sms\Drivers;

use GuzzleHttp\Psr7\Response as PsrResponse;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\Response;

class Local implements Driver
{
    /**
     * Send
     * @param mixed $to
     * @param mixed $content
     * @return \Illuminate\Http\Client\Response
     */
    public function send(string $to, string $content)
    {
        return new Response(new PsrResponse(200, [], 'OK'));
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
