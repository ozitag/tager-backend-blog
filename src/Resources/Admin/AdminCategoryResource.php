<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class AdminCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language,
            'url' => $this->url
        ];
    }
}
