<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use Illuminate\Http\Request;
use OZiTAG\Tager\Backend\Blog\Features\Guest\ListPostsByTagFeature;
use OZiTAG\Tager\Backend\Blog\Features\Guest\SearchPostsFeature;
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
        $ids = $request->get('ids');

        if ($ids) {
            $ids = array_map(function ($id) {
                return is_numeric($id) ? intval($id) : null;
            }, explode(',', $ids));

            $ids = array_filter($ids, function ($id) {
                return $id && $id > 0;
            });

            $ids = array_values(array_unique($ids));
        }

        return $this->serve(ListPostsFeature::class, [
            'language' => $request->get('lang'),
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit'),
            'ids' => $ids
        ]);
    }

    public function postsByTag(Request $request)
    {
        return $this->serve(ListPostsByTagFeature::class, [
            'language' => $request->get('lang'),
            'tag' => $request->get('tag'),
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit')
        ]);
    }

    public function viewPost($alias, Request $request)
    {
        return $this->serve(ViewPostFeature::class, [
            'alias' => $alias,
            'language' => $request->get('lang')
        ]);
    }

    public function postsByCategory($id, Request $request)
    {
        return $this->serve(ListPostsByCategoryFeature::class, [
            'id' => $id,
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit')
        ]);
    }

    public function searchPosts(Request $request)
    {
        return $this->serve(SearchPostsFeature::class, [
            'query' => $request->get('query'),
            'language' => $request->get('lang'),
            'offset' => $request->get('offset', 0),
            'limit' => $request->get('limit')
        ]);
    }
}
