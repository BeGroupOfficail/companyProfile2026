<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'count'     => (int) $this->count,
            'image_url' => $this->image ? asset("uploads/statistics/{$this->image}") : null,
        ];
    }
}
