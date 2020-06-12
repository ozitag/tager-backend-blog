<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Mail\Models\TagerMailTemplate;
use OZiTAG\Tager\Backend\Mail\Utils\TagerMailConfig;
use OZiTAG\Tager\Backend\Seo\Models\SeoPage;

class GuestPostResource extends JsonResource
{
    public function getCategories()
    {

    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'urlAlias' => $this->url_alias,
            'coverImage' => $this->coverImage ? $this->coverImage->getUrl() : null,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'categories' => $this->getCategories()
        ];
    }
}
