<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

class GuestPostFullResource extends GuestPostResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'image' => $this->image ? $this->image->getFullJson() : null,
            'body' => $this->body,
            'pageTitle' => $this->publicPageTitle,
            'pageDescription' => $this->publicPageDescription,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getFullJson() : null
        ]);
    }
}
