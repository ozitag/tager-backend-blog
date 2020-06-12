<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Mail\Models\TagerMailTemplate;
use OZiTAG\Tager\Backend\Mail\Utils\TagerMailConfig;

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
            'urlAlias' => $this->url_alias,
            'title' => $this->title,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'coverImage' => $this->coverImage ? $this->coverImage->getShortJson() : null,
            'categories' => $this->getCategoriesJson(),
        ];
    }
}
