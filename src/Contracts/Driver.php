<?php

namespace Huangdijia\Sms\Contracts;

interface Driver
{
    /**
     * Send
     * @param string $to 
     * @param string $content 
     * @return \Illuminate\Http\Client\Response|null 
     */
    public function send(string $to, string $content);

    /**
     * Info
     * @return array 
     */
    public function info();
}
