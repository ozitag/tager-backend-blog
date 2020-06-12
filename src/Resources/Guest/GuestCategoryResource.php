<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Mail\Models\TagerMailTemplate;
use OZiTAG\Tager\Backend\Mail\Utils\TagerMailConfig;

class GuestCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'urlAlias' => $this->url_alias
        ];
    }
}
