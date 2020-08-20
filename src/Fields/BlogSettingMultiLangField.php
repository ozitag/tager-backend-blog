<?php

namespace OZiTAG\Tager\Backend\Blog\Fields;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\Fields\Structures\ImageField;
use OZiTAG\Tager\Backend\Fields\Structures\StringField;
use OZiTAG\Tager\Backend\Fields\Structures\TextField;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;

class BlogSettingMultiLangField extends BlogModuleSettingField implements IModuleSettingsFieldContract
{
    public static function getParams(): array
    {
        $result = [];

        foreach (TagerBlogConfig::getLanguageIds() as $languageId) {
            foreach (static::getValues() as $value) {
                $result[] = $value . '_' . $languageId;
            }
        }

        return $result;
    }

    public static function field(string $param): Field
    {
        $p = strrpos($param, '_');
        $label = substr($param, 0, $p);
        $language = substr($param, $p + 1);

        return static::createField($label, ' (' . TagerBlogConfig::getLanguageLabel($language) . ')');
    }
}
