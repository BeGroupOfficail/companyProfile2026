<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            // 'slug'       => $this->slug,
            'short_desc' => $this->short_desc,
            'image_url'  => $this->image ? asset("uploads/services/{$this->image}") : null,
            'alt_image'  => $this->alt_image,
        ];
    }
}
