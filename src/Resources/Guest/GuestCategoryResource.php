<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;

class GuestCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var BlogCategory $model */
        $model = $this;

        return [
            'id' => $model->id,
            'language' => $model->language,
            'name' => $model->name,
            'urlAlias' => $model->url_alias,
            'children' => $model->children->map(function(BlogCategory $category){
                return new self($category);
            })
        ];
    }
}
