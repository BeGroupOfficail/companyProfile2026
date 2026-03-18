<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            // 'slug'          => $this->slug,
            'date'          => $this->date,
            'short_desc'    => $this->short_desc,
            'long_desc'    => $this->long_desc,
            'type'          => $this->type,
            'location'      => $this->location,
            'area'          => $this->area,
            'client'        => $this->client,
            'badges'        => $this->parseBadges($locale),
            'thumbnail_url' => $this->resolveThumbnail(),
            'images'        => ProjectImageResource::collection(
                $this->whenLoaded('images')
            ),
        ];
    }

    /**
     * Parse badges string "Fast - Secure - Trusted" into ["Fast", "Secure", "Trusted"]
     */
    private function parseBadges(string $locale): array
    {
        $badgesRaw = $this->getTranslation('badges', $locale);

        if (empty($badgesRaw)) {
            return [];
        }

        return array_map('trim', explode('-', $badgesRaw));
    }

    /**
     * Resolve thumbnail from first gallery image or fallback to main image column
     */
    private function resolveThumbnail(): ?string
    {
        // Try first gallery image (eager loaded)
        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            $first = $this->images->sortBy('sort_order')->first();
            return asset("uploads/projects/{$first->image}");
        }

        // Fallback to main image column
        return $this->image ? asset("uploads/projects/{$this->image}") : null;
    }
}
