<?php

namespace OZiTAG\Tager\Backend\Blog\Fields;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\Fields\Fields\ImageField;
use OZiTAG\Tager\Backend\Fields\Fields\StringField;
use OZiTAG\Tager\Backend\Fields\Fields\TextField;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

class BlogModuleSettingField extends ModuleSettingField implements IModuleSettingsFieldContract
{
    const IndexTitle = 'INDEX_TITLE';
    const IndexDescription = 'INDEX_DESCRIPTION';
    const IndexOpenGraphImage = 'INDEX_OPENGRAPH_IMAGE';
    const CategoryTitleTemplate = 'CATEGORY_TITLE_TEMPLATE';
    const CategoryDescriptionTemplate = 'CATEGORY_DESCRIPTION_TEMPLATE';
    const PostTitleTemplate = 'POST_TITLE_TEMPLATE';
    const PostDescriptionTemplate = 'POST_DESCRIPTION_TEMPLATE';

    protected static function createField(string $param, string $languagePostfix = null): Field
    {
        switch ($param) {
            case self::IndexTitle:
                return new StringField('Блог - Заголовок страницы' . $languagePostfix);

            case self::IndexDescription:
                return new TextField('Блог - Описание страницы' . $languagePostfix);

            case self::IndexOpenGraphImage:
                return new ImageField('Блог - OpenGraph картинка' . $languagePostfix, TagerBlogConfig::getOpenGraphScenario());

            case self::CategoryTitleTemplate:
                return new StringField('Категория - Заголовок страницы' . $languagePostfix);

            case self::CategoryDescriptionTemplate:
                return new TextField('Категория - Описание страницы' . $languagePostfix);

            case self::PostTitleTemplate:
                return new StringField('Пост - Заголовок страницы' . $languagePostfix);

            case self::PostDescriptionTemplate:
                return new TextField('Пост - Описание страницы' . $languagePostfix);

            default:
                return new TextField($param . $languagePostfix);
        }
    }

    public static function field(string $param): Field
    {
        return static::createField($param, '');
    }
}
