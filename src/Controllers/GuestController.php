<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use Illuminate\Http\Request;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsByTagFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\SeoParamsFeature;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListCategoriesFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsByCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ViewCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ViewPostFeature;

class GuestController extends Controller
{
    public function categories(Request $request)
    {
        return $this->serve(ListCategoriesFeature::class, [
            'language' => $request->get('lang')
        ]);
    }

    public function viewCategory($alias, Request $request)
    {
        return $this->serve(ViewCategoryFeature::class, [
            'alias' => $alias,
            'language' => $request->get('lang')
        ]);
    }

    public function posts(Request $request)
    {
        return $this->serve(ListPostsFeature::class, [
            'language' => $request->get('lang')
        ]);
    }

    public function postsByTag(Request $request)
    {
        return $this->serve(ListPostsByTagFeature::class, [
            'language' => $request->get('lang'),
            'tag' => $request->get('tag'),
        ]);
    }

    public function viewPost($alias, Request $request)
    {
        return $this->serve(ViewPostFeature::class, [
            'alias' => $alias,
            'language' => $request->get('lang')
        ]);
    }

    public function postsByCategory($id)
    {
        return $this->serve(ListPostsByCategoryFeature::class, [
            'id' => $id
        ]);
    }

    public function seoParams(Request $request)
    {
        return $this->serve(SeoParamsFeature::class, [
            'language' => $request->get('lang')
        ]);
    }
}
