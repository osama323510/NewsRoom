<?php

namespace App\Http\Resources\Article\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    return [
        'title'          => $this->title,
        'content'        => $this->content,
        'author'         => $this->user->name,
        'created_at'     => $this->created_at->toIso8601String(),
        'comments_count' => $this->comments_count ?? $this->comments()->count(),
        'reading_time'   => $this->reading_time,
        'tags'           => $this->tags->pluck('name')->toArray(),
    ];
    }
}
