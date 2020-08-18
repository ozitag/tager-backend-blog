<?php

namespace OZiTAG\Tager\Backend\Blog\Enums;

use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\Enums\SettingField;

class BlogSettingField extends SettingField
{
    const IndexTitle = 'INDEX_TITLE';
    const IndexDescription = 'INDEX_DESCRIPTION';
    const IndexOpenGraphImage = 'INDEX_OPENGRAPH_IMAGE';
    const CategoryTitleTemplate = 'CATEGORY_TITLE_TEMPLATE';
    const CategoryDescriptionTemplate = 'CATEGORY_DESCRIPTION_TEMPLATE';
    const PostTitleTemplate = 'POST_TITLE_TEMPLATE';
    const PostDescriptionTemplate = 'POST_DESCRIPTION_TEMPLATE';

    public static function model($param)
    {
        switch ($param) {
            case self::IndexTitle:
                return [
                    'type' => FieldType::String,
                    'label' => 'Блог - Заголовок страницы'
                ];

            case self::IndexDescription:
                return [
                    'type' => FieldType::Text,
                    'label' => 'Блог - Описание страницы'
                ];

            case self::IndexOpenGraphImage:
                return [
                    'type' => FieldType::Image,
                    'label' => 'Блог - OpenGraph картинка'
                ];

            case self::CategoryTitleTemplate:
                return [
                    'type' => FieldType::String,
                    'label' => 'Категория - Заголовок страницы'
                ];

            case self::CategoryDescriptionTemplate:
                return [
                    'type' => FieldType::Text,
                    'label' => 'Категория - Описание страницы'
                ];

            case self::PostTitleTemplate:
                return [
                    'type' => FieldType::String,
                    'label' => 'Пост - Заголовок страницы'
                ];

            case self::PostDescriptionTemplate:
                return [
                    'type' => FieldType::Text,
                    'label' => 'Пост - Описание страницы'
                ];

            default:
                return null;
        }
    }
}
