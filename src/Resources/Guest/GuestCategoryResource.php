<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'name' => $this->name,
            'urlAlias' => $this->url_alias
        ];
    }
}
