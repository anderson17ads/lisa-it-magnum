<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'instagram_user' => $this->instagram_user,
            'instagram_followers_count' => $this->instagram_followers_count,
            'category' => $this->category,
            'campaigns' => $this->campaigns,
        ];
    }
}
