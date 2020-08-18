<?php

namespace OZiTAG\Tager\Backend\Blog\Utils;

class TagerBlogConfig
{
    private static function config($param = null, $default = null)
    {
        return \config('tager-blog' . (empty($param) ? '' : '.' . $param), $default);
    }

    private static function getStorageScenario($id)
    {
        return self::config('file_storage_scenarios.' . $id);
    }

    public static function getPostCoverScenario()
    {
        return self::getStorageScenario('post_cover');
    }

    public static function getPostImageScenario()
    {
        return self::getStorageScenario('post_image');
    }

    public static function getOpenGraphScenario()
    {
        return self::getStorageScenario('open_graph');
    }

    /**
     * @return bool
     */
    public static function isMultiLang()
    {
        return !empty(self::config('languages', []));
    }

    /**
     * @param string $language
     * @return bool
     */
    public static function isLanguageValid($language)
    {
        return in_array($language, self::getLanguageIds());
    }

    public static function getLanguages()
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
}
