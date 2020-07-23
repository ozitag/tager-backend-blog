<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListCategoriesFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsByCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ViewCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ViewPostFeature;

class GuestController extends Controller
{
    public function categories()
    {
        return $this->serve(ListCategoriesFeature::class);
    }

    public function viewCategory($alias)
    {
        return $this->serve(ViewCategoryFeature::class, [
            'alias' => $alias
        ]);
    }

    public function posts()
    {
        return $this->serve(ListPostsFeature::class);
    }

    public function viewPost($alias)
    {
        return $this->serve(ViewPostFeature::class, [
            'alias' => $alias
        ]);
    }

    public function postsByCategory($id)
    {
        return $this->serve(ListPostsByCategoryFeature::class, [
            'id' => $id
        ]);
    }
}
