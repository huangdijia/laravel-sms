<?php

namespace Huangdijia\Sms\Validators;

use Huangdijia\Sms\Contracts\Validator;

class HkMobile implements Validator
{
    protected $mobile;

    public function __construct($mobile)
    {
        $this->mobile = $mobile;
    }

    public function validate(): bool
    {
        return preg_match('/^(4|5|6|7|8|9)\d{7}$/', $this->mobile) ? true : false;
    }

    public function message(): string
    {
        return 'Invalid hongkong mobile.';
    }
}