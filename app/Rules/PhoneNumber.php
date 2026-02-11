<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    protected $country;

    public function __construct($country = null)
    {
        $this->country = $country ?? config('app.country', 'saudi');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phone = preg_replace('/[\s\-\+]/', '', $value);

        switch (strtolower($this->country)) {
            case 'saudi':
            case 'sa':
                if (!preg_match('/^(05\d{8}|9665\d{8})$/', $phone)) {
                    $fail(__('home.The phone number must be a valid Saudi number (e.g., 05XXXXXXXX).'));
                }
                break;

            case 'egypt':
            case 'eg':
                if (!preg_match('/^(01[0-2,5]\d{8}|201[0-2,5]\d{8})$/', $phone)) {
                    $fail(__('home.The phone number must be a valid Egyptian number (e.g., 01XXXXXXXXX).'));
                }
                break;

            case 'emirates':
            case 'uae':
                if (!preg_match('/^(05[0-9]\d{7}|9715[0-9]\d{7})$/', $phone)) {
                    $fail(__('home.The phone number must be a valid UAE number (e.g., 05XXXXXXXX).'));
                }
                break;

            default:
                $fail(__('home.Invalid country specified for phone validation.'));
                break;
        }
    }
}