<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use Ozerich\FileStorage\Rules\FileRule;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Http\FormRequest;
use OZiTAG\Tager\Backend\Crud\Requests\CrudFormRequest;

class CreateBlogCategoryRequest extends CrudFormRequest
{
    public function fileScenarios()
    {
        return [
            'openGraphImage' => TagerBlogConfig::getOpenGraphScenario()
        ];
    }

    public function rules()
    {
        $result = [
            'name' => 'required|string',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', new FileRule()],
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $result['language'] = 'required|string|in:' . implode(',', TagerBlogConfig::getLanguageIds());
        }

        return $result;
    }
}
