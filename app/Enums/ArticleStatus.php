<?php
namespace App\Enums;

use App\Traits\EnumHelpers;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}