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

    public static function getLanguages()
    {
        $result = [];
        
        $languages = self::config('languages', []);

        foreach ($languages as $language) {
            $result[$language['id']] = $language['name'];
        }

        return $result;
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
