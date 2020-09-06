<?php

namespace OZiTAG\Tager\Backend\Blog\Fields;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Fields\Fields\ImageField;
use OZiTAG\Tager\Backend\Fields\Fields\StringField;
use OZiTAG\Tager\Backend\Fields\Fields\TextField;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldEnumContract;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingFieldEnum;

class BlogModuleSettingField extends ModuleSettingFieldEnum implements IModuleSettingsFieldEnumContract
{
    const IndexTitle = 'INDEX_TITLE';
    const IndexDescription = 'INDEX_DESCRIPTION';
    const IndexOpenGraphImage = 'INDEX_OPENGRAPH_IMAGE';
    const CategoryTitleTemplate = 'CATEGORY_TITLE_TEMPLATE';
    const CategoryDescriptionTemplate = 'CATEGORY_DESCRIPTION_TEMPLATE';
    const PostTitleTemplate = 'POST_TITLE_TEMPLATE';
    const PostDescriptionTemplate = 'POST_DESCRIPTION_TEMPLATE';

    protected static function createField(string $param, string $languagePostfix = null): ModuleSettingField
    {
        switch ($param) {
            case self::IndexTitle:
                return new ModuleSettingField(new StringField('Блог - Заголовок страницы' . $languagePostfix));

            case self::IndexDescription:
                return new ModuleSettingField(new TextField('Блог - Описание страницы' . $languagePostfix));

            case self::IndexOpenGraphImage:
                return new ModuleSettingField(new ImageField('Блог - OpenGraph картинка' . $languagePostfix, TagerBlogConfig::getOpenGraphScenario()));

            case self::CategoryTitleTemplate:
                return new ModuleSettingField(new StringField('Категория - Заголовок страницы' . $languagePostfix));

            case self::CategoryDescriptionTemplate:
                return new ModuleSettingField(new TextField('Категория - Описание страницы' . $languagePostfix));

            case self::PostTitleTemplate:
                return new ModuleSettingField(new StringField('Пост - Заголовок страницы' . $languagePostfix));

            case self::PostDescriptionTemplate:
                return new ModuleSettingField(new TextField('Пост - Описание страницы' . $languagePostfix));

            default:
                return new ModuleSettingField(new TextField($param . $languagePostfix));
        }
    }

    public static function field(string $param): ModuleSettingField
    {
        return static::createField($param, '');
    }
}
