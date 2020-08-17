<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Utils\Helpers\Translit;

class CreateCategoryJob extends Job
{
    private $name;

    private $language;

    public function __construct($name, $language)
    {
        $this->name = $name;
        
        $this->language = $language;
    }

    public function handle(CategoryRepository $categoryRepository)
    {
        $baseAlias = Translit::translit($this->name);

        $ind = 0;
        while (true) {
            $alias = $ind === 0 ? $baseAlias : $baseAlias . '-' . $ind;

            $exists = $categoryRepository->getByAlias($alias);
            if (!$exists) {
                return $alias;
            }

            $ind = $ind + 1;
        }
    }
}
