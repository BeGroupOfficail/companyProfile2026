<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubSectionResource;
use Illuminate\Support\Facades\Log;

class SectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            // 'key' => $this->key,
            // 'title' => $this->getTranslation('title', app()->getLocale()),
            // 'description' => $this->getTranslation('description', app()->getLocale()),
            // 'sub_sections' => SubSectionResource::collection($this->whenLoaded('subSections')),
       ];
    }
}
