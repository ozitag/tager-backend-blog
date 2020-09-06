<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Blog\Fields\BlogModuleMultiLangSettingField;
use OZiTAG\Tager\Backend\Blog\Fields\BlogModuleSettingField;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\ModuleSettings\Controllers\AdminSettingsController;

class BlogAdminSettingsController extends AdminSettingsController
{
    public function __construct()
    {
        if (TagerBlogConfig::isMultiLang()) {
            parent::__construct('blog', BlogModuleMultiLangSettingField::class, 'tager/blog');
        } else {
            parent::__construct('blog', BlogModuleSettingField::class, 'tager/blog');
        }
    }
}
