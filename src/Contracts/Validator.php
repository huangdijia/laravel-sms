<?php

namespace Huangdijia\Sms\Contracts;

interface Validator
{
    public function validate(): bool;
    public function message(): string;
}
