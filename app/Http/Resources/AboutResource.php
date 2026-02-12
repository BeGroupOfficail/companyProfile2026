<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'title'          => $this->title,
            'description'    => $this->description,
            // 'why_choose_us'  => $this->why_choose_us,
            'badges'         => $this->parseBadges($locale),
            'image_url'      => $this->resolveImageUrl('about_us', 'image', $locale),
            // 'banner_url'     => $this->resolveImageUrl('about_us', 'banner', $locale),
            'alt_image'      => $locale === 'en' ? ($this->alt_image_en ?? $this->alt_image) : $this->alt_image,
            // 'alt_banner'     => $locale === 'en' ? ($this->alt_banner_en ?? $this->alt_banner) : $this->alt_banner,
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
     * Resolve locale-aware image URL (image_en vs image for AR)
     */
    private function resolveImageUrl(string $folder, string $field, string $locale): ?string
    {
        $enField = "{$field}_en";
        $filename = ($locale === 'en' && $this->{$enField})
            ? $this->{$enField}
            : $this->{$field};

        return $filename ? asset("uploads/{$folder}/{$filename}") : null;
    }
}
