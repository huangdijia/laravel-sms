<?php

namespace Huangdijia\Sms\Validators;

use Huangdijia\Sms\Contracts\Validator;

class TwMobile implements Validator
{
    protected $mobile;

    public function __construct($mobile)
    {
        $this->mobile = $mobile;
    }

    public function validate(): bool
    {
        return preg_match('/^09\d{8}$/', $this->mobile) ? true : false;
    }

    public function message(): string
    {
        return 'Invalid taiwan mobile.';
    }
}