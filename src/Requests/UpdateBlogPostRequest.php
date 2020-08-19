<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;

class UpdateBlogPostRequest extends CreateBlogPostRequest
{
    public function rules()
    {
        $language = TagerBlogConfig::isMultiLang() ? $this->language : 'NULL';

        $uniqueRule = 'unique:tager_blog_posts,url_alias,' . $this->route('id', 0) . ',id,deleted_at,NULL';

        if (TagerBlogConfig::isMultiLang() && TagerBlogConfig::isAllowSamePostUrlAliasesForDifferentLanguages()) {
            $uniqueRule .= ',language,' . $language;
        }

        return array_merge(parent::rules(), [
            'urlAlias' => ['required', 'string', $uniqueRule],
            'samePosts.*' => ['exists:' . BlogPost::class . ',id,deleted_at,NULL', 'notIn:' . $this->route('id')]
        ]);
    }
}
