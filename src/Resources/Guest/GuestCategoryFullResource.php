<?php

namespace OZiTAG\Tager\Backend\Blog\Resources\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;

class GuestCategoryFullResource extends GuestCategoryResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'pageTitle' => $this->publicPageTitle,
            'pageDescription' => $this->publicPageDescription,
            'openGraphImage' => $this->openGraphImage ? $this->openGraphImage->getFullJson() : null
        ]);
    }
}
