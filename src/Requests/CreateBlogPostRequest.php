<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\FormRequest;
use Ozerich\FileStorage\Rules\FileRule;

class CreateBlogPostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'excerpt' => 'string|nullable',
            'body' => 'required|string',
            'date' => 'date',
            'image' => ['nullable', 'numeric', new FileRule()],
            'coverImage' => ['nullable', 'numeric', new FileRule()],
            'status' => 'required|string',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', 'numeric', new FileRule()],

            'categories' => 'array',
            'categories.*' => 'exists:' . BlogCategory::class . ',id'
        ];
    }
}
