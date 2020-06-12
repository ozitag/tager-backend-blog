<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;

class SetPostCategoriesJob
{
    private $post;

    private $categoryIds;

    public function __construct(BlogPost $post, $categoryIds)
    {
        $this->post = $post;
        $this->categoryIds = $categoryIds;
    }

    public function handle(PostCategoryRepository $postCategoryRepository, CategoryRepository $categoryRepository)
    {
        $postCategoryRepository->deleteByPostId($this->post->id);

        foreach ($this->categoryIds as $categoryId) {
            $postCategoryRepository->create([
                'post_id' => $this->post->id,
                'category_id' => $categoryId
            ]);
        }
    }
}
