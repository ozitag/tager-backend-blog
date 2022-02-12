<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Carbon\Carbon;
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
            'date' => $this->datetime ? Carbon::parse($this->datetime)->toDate()->format('Y-m-d') : null,
            'datetime' => $this->datetime,
            'excerpt' => $this->excerpt,
            'coverImage' => $this->coverImage?->getFullJson(null, false, true, [
                'tager-admin-list', 'tager-admin-view'
            ]),
            'categories' => $this->getCategoriesJson(),
        ];
    }
}
