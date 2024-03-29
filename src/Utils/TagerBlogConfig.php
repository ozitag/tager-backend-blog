<?php

namespace OZiTAG\Tager\Backend\Blog\Utils;

class TagerBlogConfig
{
    private static function config($param = null, $default = null)
    {
        return \config('tager-blog' . (empty($param) ? '' : '.' . $param), $default);
    }

    private static function getStorageScenario($id): ?string
    {
        $result = self::config('file_storage_scenarios.' . $id);
        if (!$result) {
            return null;
        } else if ($result instanceof \BackedEnum) {
            return $result->value;
        } else {
            return $result;
        }
    }

    public static function getPostCoverScenario(): ?string
    {
        return self::getStorageScenario('post_cover');
    }

    public static function getPostImageScenario(): ?string
    {
        return self::getStorageScenario('post_image');
    }

    public static function getPostImageMobileScenario(): ?string
    {
        return self::getStorageScenario('post_image_mobile');
    }

    public static function getPostContentScenario(): ?string
    {
        return self::getStorageScenario('post_content');
    }

    public static function getOpenGraphScenario(): ?string
    {
        return self::getStorageScenario('open_graph');
    }

    /**
     * @return bool
     */
    public static function isMultiLang(): bool
    {
        return !empty(self::config('languages', []));
    }

    /**
     * @param string $language
     * @return bool
     */
    public static function isLanguageValid($language): bool
    {
        return in_array($language, self::getLanguageIds());
    }

    public static function getLanguages(): array
    {
        $result = [];

        $languages = self::config('languages', []);

        foreach ($languages as $language) {
            $result[$language['id']] = $language['name'];
        }

        return $result;
    }

    private static function getLanguageConfig($language)
    {
        $languages = self::config('languages', []);

        foreach ($languages as $_language) {
            if ($_language['id'] == $language) {
                return $_language;
            }
        }

        return null;
    }

    /**
     * @param $language
     * @return bool
     */
    public static function isLanguageHideFromUrl($language)
    {
        if (self::isMultiLang() == false) {
            return false;
        }

        $languageConfig = self::getLanguageConfig($language);

        return isset($languageConfig['hide_from_url']) ? (bool)$languageConfig['hide_from_url'] : false;
    }

    /**
     * @return array
     */
    public static function getLanguageIds()
    {
        if (!self::isMultiLang()) {
            return [];
        }

        return array_map(function ($lang) {
            return $lang['id'];
        }, self::config('languages', []));
    }

    /**
     * @param $languageId
     * @return mixed|null
     */
    public static function getLanguageLabel($languageId)
    {
        $model = self::getLanguageConfig($languageId);
        return $model ? $model['name'] : null;
    }

    /**
     * @return boolean
     */
    public static function isAllowSamePostUrlAliasesForDifferentLanguages()
    {
        return (bool)self::config('validation.allow_same_post_url_aliases_for_different_languages', false);
    }

    /**
     * @return string
     */
    public static function getCategoryUrlTemplate()
    {
        return (string)config('tager-blog.url_templates.category', '/category/{alias}');
    }

    /**
     * @return string
     */
    public static function getPostUrlTemplate()
    {
        return (string)config('tager-blog.url_templates.post', '/post/{alias}');
    }

    public static function getPostIndexTemplate()
    {
        return (string)config('tager-blog.url_templates.index', null);
    }

    /**
     * @return array
     */
    public static function getPostAdditionalFields()
    {
        return config('tager-blog.fields.post', []);
    }

    /**
     * @return array
     */
    public static function getShortcodes()
    {
        return config('tager-blog.shortcodes', []);
    }

    /**
     * @param $field
     * @return mixed|null
     */
    public static function getPostAdditionalField($field)
    {
        $fields = self::getPostAdditionalFields();
        return $fields[$field] ?? null;
    }

    /**
     * @return string
     */
    public static function getShortResourceClass()
    {
        return config('tager-blog.short_resource_class', null);
    }

    /**
     * @return string
     */
    public static function getFullResourceClass()
    {
        return config('tager-blog.full_resource_class', null);
    }
}
