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
            'url' => $this->url,
            'date' => $this->date,
            'status' => $this->status,
            'excerpt' => $this->excerpt,
            'image' => $this->image ? $this->image->getShortJson() : null,
            'categories' => $this->getCategoriesJson()
        ];
    }
}
