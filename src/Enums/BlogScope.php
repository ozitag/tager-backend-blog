<?php

namespace OZiTAG\Tager\Backend\Blog\Enums;

enum BlogScope: string
{
    case Settings = 'blog.settings';
    case CategoriesEdit = 'blog.edit-categories';
    case CategoriesCreate = 'blog.create-categories';
    case CategoriesDelete = 'blog.delete-categories';
    case PostsEdit = 'blog.edit-posts';
    case PostsCreate = 'blog.create-posts';
    case PostsDelete = 'blog.delete-posts';
}
