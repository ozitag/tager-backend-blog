<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Core\Validation\ValidationException;

abstract class BaseFeature extends Feature
{
    protected $language;

    public function __construct($language)
    {
        if (TagerBlogConfig::isMultiLang() == false) {
            return;
        }

        if (empty($language)) {
            abort(400, 'Lang is required');
        }

        if (TagerBlogConfig::isLanguageValid($language) == false) {
            abort(400, 'Lang is not valid');
        }

        $this->language = $language;
    }
}
