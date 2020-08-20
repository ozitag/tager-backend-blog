<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Fields\BlogSettingMultiLangField;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\ModuleSettings\Controllers\AdminSettingsController;

class BlogAdminSettingsController extends AdminSettingsController
{
    public function __construct()
    {
        if (TagerBlogConfig::isMultiLang()) {
            parent::__construct('blog', BlogSettingMultiLangField::class);
        } else {
            parent::__construct('blog', BlogSettingField::class);
        }
    }
}
