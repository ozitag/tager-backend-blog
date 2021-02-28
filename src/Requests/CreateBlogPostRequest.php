<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Http\FormRequest;
use Ozerich\FileStorage\Rules\FileRule;
use OZiTAG\Tager\Backend\Crud\Requests\CrudFormRequest;

class CreateBlogPostRequest extends CrudFormRequest
{
    public function fileScenarios()
    {
        return [
            'openGraphImage' => TagerBlogConfig::getOpenGraphScenario(),
            'image' => TagerBlogConfig::getPostImageScenario(),
            'coverImage' => TagerBlogConfig::getPostCoverScenario()
        ];
    }

    public function rules()
    {
        $result = [
            'title' => 'required|string',
            'excerpt' => 'string|nullable',
            'body' => 'required|string',
            'date' => 'nullable|date',
            'image' => ['nullable', new FileRule()],
            'coverImage' => ['nullable', new FileRule()],
            'status' => 'required|string',

            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', new FileRule()],

            'categories' => 'array',
            'categories.*' => 'exists:' . BlogCategory::class . ',id,deleted_at,NULL',

            'relatedPosts' => 'array',
            'relatedPosts.*' => 'exists:' . BlogPost::class . ',id,deleted_at,NULL',

            'tags' => 'array',
            'tags.*' => 'string',

            'additionalFields' => 'array',
            'additionalFields.*.name' => 'string',
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $result['language'] = 'required|string|in:' . implode(',', TagerBlogConfig::getLanguageIds());
        }

        return $result;
    }
}
