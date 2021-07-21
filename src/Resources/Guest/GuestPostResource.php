<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Files\Enums\TagerFileThumbnail;

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
            'coverImage' => $this->coverImage ? $this->coverImage->getFullJson(null, false, true, [TagerFileThumbnail::AdminList, TagerFileThumbnail::AdminView]) : null,
            'categories' => $this->getCategoriesJson(),
        ];
    }
}
