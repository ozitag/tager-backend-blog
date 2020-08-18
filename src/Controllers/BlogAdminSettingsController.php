<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Enums\BlogSettingField;
use OZiTAG\Tager\Backend\ModuleSettings\Controllers\AdminSettingsController;

class BlogAdminSettingsController extends AdminSettingsController
{
    public function __construct()
    {
        parent::__construct('blog', BlogSettingField::class);
    }
}
