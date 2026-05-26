<?php

namespace App\contract;
use App\Models\Article;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    public function allPublished(): Collection;
    public function find(int $id): ?Article;
    public function create(array $data);
    public function update($id,array $data): Article;
    public function delete(int $id): bool;
    public function publish(int $id);
    public function archive($days);
}
