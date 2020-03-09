<?php

namespace Huangdijia\Sms\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwMobile implements Rule
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
        return preg_match('/^09\d{8}$/', $this->mobile) ? true : false;
    }

    /**
     * message
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be tw mobile.';
    }
}