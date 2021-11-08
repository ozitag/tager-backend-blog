<?php

namespace OZiTAG\Tager\Backend\Blog\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

final class BlogPostStatus extends Enum
{
    const Published = 'PUBLISHED';
    const Archived = 'ARCHIVED';
    const Draft = 'DRAFT';
}
