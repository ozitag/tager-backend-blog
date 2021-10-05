<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetChildrenIdsForCategoryJob extends Job
{
    /** @var BlogCategory */
    protected BlogCategory $category;

    public function __construct(BlogCategory $category)
    {
        $this->category = $category;
    }

    private function rec(BlogCategory $category)
    {
        $result = [];
        foreach ($category->children as $child) {
            $result[] = $child->id;
            foreach ($this->rec($child) as $childId) {
                $result[] = $childId;
            }
        }
        return $result;
    }

    public function handle()
    {
        return $this->rec($this->category);
    }
}
