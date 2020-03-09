<?php

namespace Huangdijia\Sms\Contracts;

interface Driver
{
    public function getConfig();
    public function send(string $to, string $content);
    public function info();
}
