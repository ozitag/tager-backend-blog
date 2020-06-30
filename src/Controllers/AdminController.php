<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use OZiTAG\Tager\Backend\Core\Controller;
use OZiTAG\Tager\Backend\Blog\Features\Admin\CreateCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\CreatePostFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ListCategoriesFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ListPostsByCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ListPostsFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\RemoveCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\RemovePostFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\UpdateCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\UpdatePostFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ViewCategoryFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\ViewPostFeature;
use OZiTAG\Tager\Backend\Blog\Features\Admin\MoveCategoryFeature;

class AdminController extends Controller
{
    public function listCategories()
    {
        return $this->serve(ListCategoriesFeature::class);
    }

    public function viewCategory($id)
    {
        return $this->serve(ViewCategoryFeature::class, ['id' => $id]);
    }

    public function createCategory()
    {
        return $this->serve(CreateCategoryFeature::class);
    }

    public function updateCategory($id)
    {
        return $this->serve(UpdateCategoryFeature::class, ['id' => $id]);
    }

    public function moveCategory($id, $direction)
    {
        return $this->serve(MoveCategoryFeature::class, ['id' => $id, 'direction' => $direction]);
    }

    public function removeCategory($id)
    {
        return $this->serve(RemoveCategoryFeature::class, ['id' => $id]);
    }

    public function listPosts()
    {
        return $this->serve(ListPostsFeature::class);
    }

    public function listPostsByCategory($id)
    {
        return $this->serve(ListPostsByCategoryFeature::class, ['id' => $id]);
    }

    public function createPost()
    {
        return $this->serve(CreatePostFeature::class);
    }

    public function viewPost($id)
    {
        return $this->serve(ViewPostFeature::class, ['id' => $id]);
    }

    public function updatePost($id)
    {
        return $this->serve(UpdatePostFeature::class, ['id' => $id]);
    }

    public function removePost($id)
    {
        return $this->serve(RemovePostFeature::class, ['id' => $id]);
    }
}
