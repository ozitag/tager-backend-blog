<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Features\Admin\ListPostsByCategoryFeature;
use OZiTAG\Tager\Backend\Crud\Controllers\AdminCrudController;
use OZiTAG\Tager\Backend\Blog\Operations\CreateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Operations\UpdateCategoryOperation;
use OZiTAG\Tager\Backend\Blog\Jobs\CheckIfCanDeleteCategoryJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogCategoryRequest;

class BlogAdminCategoriesController extends AdminCrudController
{
    public $hasMoveAction = true;

    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);

        $fields = [
            'id', 'name', 'url', 'language',
            'postsCount'
        ];

        $this->setResourceFields($fields);

        $this->setFullResourceFields(array_merge($fields, [
            'urlTemplate' => function ($model) {
                return str_replace($model->url_alias, '{alias}', $model->url);
            },
            'urlAlias' => 'url_alias',
            'pageTitle' => 'page_title',
            'pageDescription' => 'page_description',
            'openGraphImage:file:model',
        ]));

        $this->setStoreAction(CreateBlogCategoryRequest::class, CreateCategoryOperation::class);

        $this->setUpdateAction(UpdateBlogCategoryRequest::class, UpdateCategoryOperation::class);

        $this->setDeleteAction(CheckIfCanDeleteCategoryJob::class);

        $this->setCacheNamespace('blog');
    }

    public function listPostsByCategory($id)
    {
        return $this->serve(ListPostsByCategoryFeature::class, ['id' => $id]);
    }
}
