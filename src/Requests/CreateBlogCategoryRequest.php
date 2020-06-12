<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Core\FormRequest;
use Ozerich\FileStorage\Rules\FileRule;

class CreateBlogCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', 'numeric', new FileRule()],
        ];
    }
}