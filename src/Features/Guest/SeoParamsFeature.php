<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Enums\BlogSettingField;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettings;

class SeoParamsFeature extends Feature
{
    public function handle(ModuleSettings $settings)
    {
        return new JsonResource([
            'indexPageTitle' => $settings->getPublicValue(
                'blog',
                BlogSettingField::IndexTitle,
                FieldType::String
            ),
            'indexPageDescription' => $settings->getPublicValue(
                'blog',
                BlogSettingField::IndexDescription,
                FieldType::Text
            ),
            'indexPageOpenGraphImage' => $settings->getPublicValue(
                'blog',
                BlogSettingField::IndexOpenGraphImage,
                FieldType::Image
            )
        ]);
    }
}
