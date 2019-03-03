<?php

namespace App\Rules;

use BrightComponents\Valid\CustomRule;

class RequiredIfRecurringRule extends CustomRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->validator->getData()['recurring']) {
            return $value ? true : false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Recurring bills must have a "recurring period" set';
    }
}
