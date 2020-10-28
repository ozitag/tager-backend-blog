<?php

namespace OZiTAG\Tager\Backend\Blog\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

final class BlogScope extends Enum
{
    const Settings = 'blog.settings';
    const CategoriesEdit = 'blog.edit-categories';
    const CategoriesCreate = 'blog.create-categories';
    const CategoriesDelete = 'blog.delete-categories';
    const PostsEdit = 'blog.edit-posts';
    const PostsCreate = 'blog.create-posts';
    const PostsDelete = 'blog.delete-posts';
}
