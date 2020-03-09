<?php

namespace Huangdijia\Sms\Rules;

use Illuminate\Contracts\Validation\Rule;

class HkMobile implements Rule
{
    /**
     * Passes
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(4|5|6|7|8|9)\d{7}$/', $this->mobile) ? true : false;
    }

    /**
     * message
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be hk mobile.';
    }
}