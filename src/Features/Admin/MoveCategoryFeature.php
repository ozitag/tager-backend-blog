<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryByIdJob;
use OZiTAG\Tager\Backend\Blog\Jobs\MoveCategoryJob;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\SuccessResource;

class MoveCategoryFeature extends Feature
{
    private $id;

    private $direction;

    public function __construct($id, $direction)
    {
        $this->id = $id;

        $this->direction = $direction;
    }

    public function handle()
    {
        $model = $this->run(GetCategoryByIdJob::class, ['id' => $this->id]);
        if (!$model) {
            abort(404, 'Category not found');
        }

        $this->run(MoveCategoryJob::class, [
            'model' => $model,
            'direction' => $this->direction
        ]);

        return new SuccessResource();
    }
}
