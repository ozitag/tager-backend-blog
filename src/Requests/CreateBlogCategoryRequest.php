<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Http\FormRequest;
use Ozerich\FileStorage\Rules\FileRule;

class CreateBlogCategoryRequest extends FormRequest
{
    public function rules()
    {
        $result = [
            'name' => 'required|string',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', 'numeric', new FileRule()],
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $result['language'] = 'required|string|in:' . implode(',', TagerBlogConfig::getLanguageIds());
        }

        return $result;
    }
}
