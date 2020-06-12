<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Mail\Models\TagerMailTemplate;
use OZiTAG\Tager\Backend\Mail\Utils\TagerMailConfig;
use OZiTAG\Tager\Backend\Seo\Models\SeoPage;

class AdminCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'urlAlias' => $this->url_alias,
            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getJson() : null,
            'websiteUrl' => '/' . $this->url_alias
        ];
    }
}
