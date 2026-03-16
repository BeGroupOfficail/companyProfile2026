<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'phone'        => $this->phone1,
            // 'phone2'        => $this->phone2,
            // 'phone3'        => $this->phone3,
            // 'telephone'     => $this->telephone,
            // 'fax'           => $this->fax,
            // 'whatsapp'      => $this->side_whatsapp,
            'email' => $this->contact_email,
            // 'support_email' => $this->support_email,
            'address'       => $locale === 'en'
                ? ($this->address_en_1 ?? $this->address1)
                : $this->address1,
            // 'address2'      => $locale === 'en'
            //     ? ($this->address_en_2 ?? $this->address2)
            //     : $this->address2,
            // 'google_map'    => $this->google_map,
        ];
    }
}
