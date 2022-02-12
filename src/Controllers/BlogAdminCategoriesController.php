<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Crud\Actions\DeleteAction;
use OZiTAG\Tager\Backend\Crud\Actions\IndexAction;
use OZiTAG\Tager\Backend\Crud\Actions\StoreOrUpdateAction;
use OZiTAG\Tager\Backend\Crud\Controllers\AdminCrudController;
use OZiTAG\Tager\Backend\Blog\Operations\CreateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Operations\UpdateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Jobs\CheckIfCanDeleteCategoryJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogCategoryRequest;

class BlogAdminCategoriesController extends AdminCrudController
{
    public bool $hasMoveAction = true;

    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);

        $this->setIndexAction((new IndexAction())->enableTree());

        $fields = [
            'id',
            'depth',
            'parent' => [
                'relation' => 'parent',
                'as' => [
                    'id',
                    'name'
                ]
            ],
            'name',
            'url' => function (BlogCategory $category) {
                return $category->getWebPageUrl();
            }, 'language',
            'postsCount',
            'isDefault' => 'is_default:boolean',
        ];

        $this->setResourceFields($fields);

        $this->setFullResourceFields(array_merge($fields, [
            'isDefault' => 'is_default:boolean',
            'urlTemplate' => function (BlogCategory $model) {
                return str_replace($model->url_alias, '{alias}', $model->getWebPageUrl());
            },
            'urlAlias' => 'url_alias',
            'pageTitle' => 'page_title',
            'pageDescription' => 'page_description',
            'openGraphImage:file:model',
        ]));

        $this->setStoreAction(new StoreOrUpdateAction(CreateBlogCategoryRequest::class, CreateCategoryOperation::class));

        $this->setUpdateAction(new StoreOrUpdateAction(UpdateBlogCategoryRequest::class, UpdateCategoryOperation::class));

        $this->setDeleteAction(new DeleteAction(CheckIfCanDeleteCategoryJob::class));

        $this->setCacheNamespace('tager/blog');
    }
}
