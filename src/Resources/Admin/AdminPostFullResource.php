<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPostFullResource extends AdminPostResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'urlTemplate' => str_replace($this->url_alias, '{alias}', $this->url),
            'urlAlias' => $this->url_alias,
            'body' => $this->body,
            'image' => $this->image ? $this->image->getShortJson() : null,
            'coverImage' => $this->coverImage ? $this->coverImage->getShortJson() : null,

            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getShortJson() : null,
        ]);
    }
}
