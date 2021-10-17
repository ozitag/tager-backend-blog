<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Pages\Models\TagerPage;

class ClonePostCategoriesJob extends Job
{
    protected BlogPost $source;
    protected BlogPost $dest;

    public function __construct(BlogPost $source, BlogPost $dest)
    {
        $this->source = $source;

        $this->dest = $dest;
    }

    public function handle(PostCategoryRepository $postCategoryRepository)
    {
        foreach ($this->source->categories as $category) {
            $postCategoryRepository->create([
                'post_id' => $this->dest->id,
                'category_id' => $category->id
            ]);
        }
    }
}
