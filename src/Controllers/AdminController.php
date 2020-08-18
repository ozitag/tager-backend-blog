<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ModuleInfoFeature;

class AdminController extends Controller
{
    public function moduleInfo()
    {
        return $this->serve(ModuleInfoFeature::class);
    }
}
