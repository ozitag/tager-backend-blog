<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPriorityForNewCategoryJob;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class ModuleInfoFeature extends Feature
{
    public function handle(TagerBlogUrlHelper $urlHelper)
    {
        $languages = TagerBlogConfig::getLanguages();

        $languagesResult = [];
        foreach ($languages as $language => $label) {
            $languagesResult[] = [
                'id' => $language,
                'name' => $label
            ];
        }

        return new JsonResource([
            'postContentImageScenario' => TagerBlogConfig::getPostContentScenario(),
            'languages' => $languagesResult
        ]);
    }
}
