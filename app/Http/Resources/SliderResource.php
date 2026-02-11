<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'text'      => $this->text,
            'link'      => $this->link,
            'image_url' => $this->image ? asset("uploads/sliders/{$this->image}") : null,
            'alt_image' => $this->alt_image,
        ];
    }
}
