<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;

class GuestCategoryFullResource extends GuestCategoryResource
{
    public function toArray($request)
    {
        /** @var BlogCategory $model */
        $model = $this->resource;

        return array_merge(parent::toArray($request), [
            'pageTitle' => $model->getWebPageTitle(),
            'pageDescription' => $model->getWebPageDescription(),
            'openGraphImage' => $model->getWebOpenGraphImageUrl(),
            'children' => $model->children->map(function(BlogCategory $category){
                return new GuestCategoryResource($category);
            })
        ]);
    }
}
