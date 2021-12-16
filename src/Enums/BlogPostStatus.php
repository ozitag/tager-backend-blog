<?php

namespace OZiTAG\Tager\Backend\Blog\Enums;

enum BlogPostStatus: string
{
    case Published = 'PUBLISHED';
    case Archived = 'ARCHIVED';
    case Draft = 'DRAFT';
}
