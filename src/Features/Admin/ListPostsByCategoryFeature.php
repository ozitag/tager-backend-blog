<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Core\Feature;

class ListPostsByCategoryFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
    }
}
