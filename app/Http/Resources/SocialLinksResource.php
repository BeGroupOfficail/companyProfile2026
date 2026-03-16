<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinksResource extends JsonResource
{
    /**
     * Return social links as structured array, filtering out empty values.
     */
    public function toArray(Request $request): array
    {
        $platforms = [
            'facebook'  => $this->facebook_address,
            'twitter'   => $this->twitter_address,
            'instagram' => $this->instagram_address,
            'linkedin'  => $this->linkedin_address,
            'youtube'   => $this->youtube_address,
            'tiktok'    => $this->tiktok_address,
            'snapchat'  => $this->snapchat_address,
            'whatsapp'  => $this->whatsapp_address,
            'pinterest' => $this->pinterest_address,
            'threads'   => $this->threads_address,
            'tumblr'    => $this->tumblr_address,
            'flickr'    => $this->flickr_address,
        ];

        $links = [];
        foreach ($platforms as $platform => $url) {
            if (!empty($url)) {
                $links[] = [
                    'platform' => $platform,
                    'url'      => $url,
                ];
            }
        }

        return $links;
    }
}
