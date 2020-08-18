<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestPostResource extends JsonResource
{
    public function getCategoriesJson()
    {
        $result = [];

        foreach ($this->categories as $category) {
            $result[] = [
                'urlAlias' => $category->url_alias,
                'name' => $category->name,
            ];
        }

        return $result;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'urlAlias' => $this->url_alias,
            'title' => $this->title,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'coverImage' => $this->coverImage ? $this->coverImage->getFullJson() : null,
            'categories' => $this->getCategoriesJson(),
        ];
    }
}
