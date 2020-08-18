<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class AdminCategoryFullResource extends AdminCategoryResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'urlTemplate' => str_replace($this->url_alias, '{alias}', $this->url),
            'urlAlias' => $this->url_alias,
            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getShortJson() : null,
        ]);
    }
}
