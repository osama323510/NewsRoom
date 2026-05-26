<?php

namespace App\Http\Resources\Article\v1;

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
        
        return 
        [
            'id'      => $this->id,
            'title'   => $this->title,
            'content' => $this->content,
            'author'  => $this->user->name,
            'comments ' => $this->comments_count ?? $this->comments,
            'created_at' => $this->created_at->toIso8601String(),

        ];
    }
}

