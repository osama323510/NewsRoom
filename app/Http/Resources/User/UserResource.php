<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'articles_count' => $this->resource['articles_count'] ?? 0,
            'comments_count' => $this->resource['comments_count'] ?? 0,
            'active_writers' => $this->resource['active_writers'] ?? [],
            'most_used_tags' => $this->resource['most_used_tags'] ?? [],
        ];
    }
}
