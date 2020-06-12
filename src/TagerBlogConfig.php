<?php

namespace OZiTAG\Tager\Backend\Blog;

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
}
