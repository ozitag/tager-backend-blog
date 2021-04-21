<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Operations\CreatePostOperation;
use OZiTAG\Tager\Backend\Blog\Operations\UpdatePostOperation;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogPostRequest;
use OZiTAG\Tager\Backend\Crud\Actions\IndexAction;
use OZiTAG\Tager\Backend\Crud\Actions\StoreOrUpdateAction;
use OZiTAG\Tager\Backend\Crud\Controllers\AdminCrudController;

class BlogAdminPostsController extends AdminCrudController
{
    public bool $hasCountAction = true;

    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);

        $fields = [
            'id', 'language', 'title',
            'url' => function (BlogPost $blogPost) {
                return $blogPost->getWebPageUrl();
            },
            'date', 'status', 'excerpt',
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

            'tags' => 'tagsArray',

            'additionalFields' => 'additionalFields'
        ]));

        $this->setIndexAction((new IndexAction())->enablePagination()->enableSearchByQuery());

        $this->setStoreAction(new StoreOrUpdateAction(CreateBlogPostRequest::class, CreatePostOperation::class));

        $this->setUpdateAction(new StoreOrUpdateAction(UpdateBlogPostRequest::class, UpdatePostOperation::class));

        $this->setCacheNamespace('tager/blog');
    }
}
