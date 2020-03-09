<?php

namespace Huangdijia\Sms\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnMobile implements Rule
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
        return preg_match('/^1\d{10}$/', $value) ? true : false;
    }

    /**
     * message
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be cn mobile.';
    }
}