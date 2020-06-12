<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestPostFullResource extends GuestPostResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'body' => $this->body,
            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getFullJson() : null
        ]);
    }
}
