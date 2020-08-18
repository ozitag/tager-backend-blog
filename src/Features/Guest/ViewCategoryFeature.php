<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryFullResource;

class ViewCategoryFeature extends BaseFeature
{
    private $alias;

    public function __construct($alias, $language)
    {
        parent::__construct($language);

        $this->alias = $alias;
    }

    public function handle(CategoryRepository $categoryRepository)
    {
        $model = $categoryRepository->getByAlias($this->alias, $this->language);
        
        if (!$model) {
            abort(404, 'Category not found');
        }

        return new GuestCategoryFullResource($model);
    }
}
