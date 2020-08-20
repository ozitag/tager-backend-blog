<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Features\Admin\ListPostsByCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Operations\CreatePostOperation;
use OZiTAG\Tager\Backend\Blog\Operations\UpdatePostOperation;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogPostRequest;
use OZiTAG\Tager\Backend\Crud\Controllers\AdminCrudController;
use OZiTAG\Tager\Backend\Blog\Operations\CreateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Operations\UpdateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Jobs\CheckIfCanDeleteCategoryJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogCategoryRequest;

class BlogAdminPostsController extends AdminCrudController
{
    public $hasCountAction = true;

    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);

        $fields = [
            'id', 'language', 'title', 'url', 'date', 'status', 'excerpt',
            'image' => 'coverImage:file:url',
            'categories' => [
                'relation' => 'categories',
                'as' => ['id', 'name']
            ]
        ];

        $this->setResourceFields($fields);

        $this->setFullResourceFields(array_merge($fields, [
            'urlTemplate' => function ($model) {
                return str_replace($model->url_alias, '{alias}', $model->url);
            },
            'urlAlias' => 'url_alias',

            'body',
            'image:file:model',
            'coverImage:file:model',

            'pageTitle' => 'page_title',
            'pageDescription' => 'page_description',
            'openGraphImage:file:model',

            'relatedPosts' => [
                'relation' => 'relatedPosts',
                'as' => ['id', 'title']
            ],

            'tags' => 'tagsArray'
        ]));

        $this->setStoreAction(CreateBlogPostRequest::class, CreatePostOperation::class);

        $this->setUpdateAction(UpdateBlogPostRequest::class, UpdatePostOperation::class);

        $this->setCacheNamespace('blog');
    }
}
