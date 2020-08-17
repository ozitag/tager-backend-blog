<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPostResource extends JsonResource
{
    public function getCategoriesJson()
    {
        $result = [];

        foreach($this->categories as $category){
            $result[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }

        return $result;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'title' => $this->title,
            'urlAlias' => $this->url_alias,
            'date' => $this->date,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'image' => $this->image ? $this->image->getShortJson() : null,
            'coverImage' => $this->coverImage ? $this->coverImage->getShortJson() : null,

            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getShortJson() : null,

            'categories' => $this->getCategoriesJson()
        ];
    }
}
