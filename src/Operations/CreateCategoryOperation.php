<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPriorityForNewCategoryJob;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class CreateCategoryOperation extends Operation
{
    private $request;

    public function __construct(CreateBlogCategoryRequest $request)
    {
        $this->request = $request;
    }

    public function handle(CategoryRepository $categoryRepository, Storage $fileStorage)
    {
        $request = $this->request;

        $alias = $this->run(GetCategoryUrlAliasJob::class, [
            'name' => $request->name,
            'language' => $request->language,
        ]);

        $maxPriority = $this->run(GetPriorityForNewCategoryJob::class, [
            'language' => TagerBlogConfig::isMultiLang() ? $request->language : null
        ]);

        $fields = [
            'name' => $request->name,
            'url_alias' => $alias,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage,
            'priority' => $maxPriority
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $fields['language'] = $request->language;
        }

        $model = $categoryRepository->create($fields);

        return $model;
    }
}
