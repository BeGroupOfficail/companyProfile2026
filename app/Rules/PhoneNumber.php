<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

class PhoneNumber implements ValidationRule
{
    public function __construct(
        protected ?string $countryField = null
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Nullable support
        if ($value === null || $value === '') {
            return;
        }

        // Reject international format
        if (str_starts_with(trim($value), '+')) {
            $fail(__('dash.use_national_number_only'));
            return;
        }

        $countryIso = null;

        //  Explicit mapping (best)
        if ($this->countryField) {
            $countryIso = request()->input($this->countryField);
        }

        //  Dynamic array handling: responsibles.X.phone → responsibles.X.country_iso
        if (! $countryIso && str_contains($attribute, '.')) {
            $segments = explode('.', $attribute);
            array_pop($segments);        // remove 'phone'
            $segments[] = 'country_iso';

            $derivedKey = implode('.', $segments);
            $countryIso = request()->input($derivedKey);
        }

        // Global fallback
        $countryIso ??= request()->input('country_iso');

        if (! $countryIso) {
            $fail(__('dash.invalid_country_code'));
            return;
        }

        try {
            $util = PhoneNumberUtil::getInstance();
            $phoneProto = $util->parse($value, strtoupper($countryIso));

            if (! $util->isValidNumber($phoneProto)) {
                $fail(__('dash.invalid_phone'));
            }
        } catch (NumberParseException) {
            $fail(__('dash.invalid_phone'));
        }
    }
}