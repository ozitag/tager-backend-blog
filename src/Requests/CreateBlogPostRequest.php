<?php

namespace OZiTAG\Tager\Backend\Seo\Requests;

use OZiTAG\Tager\Backend\Core\FormRequest;
use Ozerich\FileStorage\Rules\FileRule;

class CreateBlogPostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'title' => 'required|string',
            'excerpt' => 'string',
            'body' => 'required|string',
            'date' => 'string',
            'image' => ['nullable', 'numeric', new FileRule()],
            'coverImage' => ['nullable', 'numeric', new FileRule()],
            'status' => 'required|string',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', 'numeric', new FileRule()],
        ];
    }
}