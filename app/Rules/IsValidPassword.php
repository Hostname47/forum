<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class IsValidPassword implements Rule
{
    public $lengthPasses = true;
    public $uppercasePasses = true;
    public $lowercasePasses = true;
    public $numericPasses = true;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = strlen($value) >= 8;
        $this->uppercasePasses = ((bool) preg_match('/[A-Z]/', $value));
        $this->lowercasePasses = ((bool) preg_match('/[a-z]/', $value));
        $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));

        return ($this->lengthPasses && $this->uppercasePasses && $this->lowercasePasses && $this->numericPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case !$this->uppercasePasses:
                return __('The password must contains at least one uppercase character');
            case !$this->lowercasePasses:
                return __('The password must contains at least one lowercase character');
            case !$this->numericPasses:
                return __('The password must contains at least one digit');
            default:
                return __('The password must contain at least 8 characters');
        }
    }
}