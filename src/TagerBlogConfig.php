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
        return self::config('fileStorageScenarios.' . $id);
    }

    public static function getPostCoverScenario()
    {
        return self::getStorageScenario('post-cover');
    }

    public static function getPostImageScenario()
    {
        return self::getStorageScenario('post-image');
    }

    public static function getOpenGraphScenario()
    {
        return self::getStorageScenario('open-graph');
    }
}
