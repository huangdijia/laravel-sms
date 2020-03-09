<?php

namespace Huangdijia\Sms\Validators;

use Huangdijia\Sms\Contracts\Validator;

class CnMobile implements Validator
{
    protected $mobile;

    public function __construct($mobile)
    {
        $this->mobile = $mobile;
    }

    public function validate(): bool
    {
        return preg_match('/^1\d{10}$/', $this->mobile) ? true : false;
    }

    public function message(): string
    {
        return 'Invalid hongkong mobile.';
    }
}