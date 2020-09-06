<?php

namespace OZiTAG\Tager\Backend\Blog\Fields;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldEnumContract;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

class BlogModuleMultiLangSettingField extends BlogModuleSettingField implements IModuleSettingsFieldEnumContract
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

    public static function field(string $param): ModuleSettingField
    {
        $p = strrpos($param, '_');
        $label = substr($param, 0, $p);
        $language = substr($param, $p + 1);

        return static::createField($label, ' (' . TagerBlogConfig::getLanguageLabel($language) . ')');
    }
}
