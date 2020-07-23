<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryByIdJob;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;

class ViewCategoryFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $model = $this->run(GetCategoryByIdJob::class, ['id' => $this->id]);
        if (!$model) {
            abort(404, 'Category not found');
        }

        return new AdminCategoryResource($model);
    }
}
