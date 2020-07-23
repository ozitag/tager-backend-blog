<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

class GuestCategoryFullResource extends GuestCategoryResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'pageTitle' => $this->page_title,
            'pageDescription' => $this->page_description,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getFullJson() : null
        ]);
    }
}
