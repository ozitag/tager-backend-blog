<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetPostByIdJob;
use OZiTAG\Tager\Backend\Blog\Resources\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ViewPostFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $model = $this->run(GetPostByIdJob::class, [
            'id' => $this->id
        ]);

        if (!$model) {
            abort(404, 'Post not found');
        }

        return new AdminPostResource($model);
    }
}