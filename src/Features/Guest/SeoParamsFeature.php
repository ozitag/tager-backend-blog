<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Fields\BlogModuleSettingField;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettings;

class SeoParamsFeature extends BaseFeature
{
    public function handle(ModuleSettings $settings)
    {
        return new JsonResource([
            'indexPageTitle' => $settings->getPublicValue(
                'blog',
                BlogModuleSettingField::IndexTitle . ($this->language ? '_' . $this->language : null),
                FieldType::String
            ),
            'indexPageDescription' => $settings->getPublicValue(
                'blog',
                BlogModuleSettingField::IndexDescription . ($this->language ? '_' . $this->language : null),
                FieldType::Text
            ),
            'indexPageOpenGraphImage' => $settings->getPublicValue(
                'blog',
                BlogModuleSettingField::IndexOpenGraphImage . ($this->language ? '_' . $this->language : null),
                FieldType::Image
            )
        ]);
    }
}
