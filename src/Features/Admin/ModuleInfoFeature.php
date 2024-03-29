<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

class ModuleInfoFeature extends Feature
{
    private function getLanguages()
    {
        $languages = TagerBlogConfig::getLanguages();

        $languagesResult = [];
        foreach ($languages as $language => $label) {
            $languagesResult[] = [
                'id' => $language,
                'name' => $label,
                'defaultCategories' => []
            ];
        }

        return $languagesResult;
    }

    private function getFields()
    {
        $fields = TagerBlogConfig::getPostAdditionalFields();

        $fieldsResult = [];
        foreach ($fields as $fieldName => $fieldConfig) {
            if (!isset($fieldConfig['type']) || !isset($fieldConfig['label'])) continue;

            $field = FieldFactory::create($fieldConfig['type'], $fieldConfig['label'], $fieldConfig['meta'] ?? null);
            $field->setName($fieldName);
            $fieldsResult[] = $field->getJson();
        }

        return $fieldsResult;
    }

    private function getShortcodes()
    {
        $config = TagerBlogConfig::getShortcodes();

        $result = [];

        foreach ($config as $code => $data) {
            $params = isset($data['params']) && is_array($data['params']) ? $data['params'] : [];

            $paramsFiltered = [];
            foreach ($params as $id => $label) {
                $paramsFiltered[] = [
                    'name' => $id,
                    'label' => $label
                ];
            }

            $result[] = [
                'name' => $code,
                'params' => $paramsFiltered
            ];
        }

        return $result;
    }

    private function getDefaultCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->builder()->where('is_default', '=', true)->get();

        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'language' => $category->language,
            ];
        }

        return $result;
    }

    public function handle(CategoryRepository $categoryRepository)
    {
        return new JsonResource([
            'urlCategoryTemplate' => config('app.url') . TagerBlogConfig::getCategoryUrlTemplate(),
            'urlPostTemplate' => config('app.url') . TagerBlogConfig::getPostUrlTemplate(),
            'languages' => $this->getLanguages(),
            'fields' => $this->getFields(),
            'shortcodes' => $this->getShortcodes(),
            'defaultCategories' => $this->getDefaultCategories($categoryRepository),
            'fileScenarios' => [
                'cover' => TagerBlogConfig::getPostCoverScenario(),
                'image' => TagerBlogConfig::getPostImageScenario(),
                'imageMobile' => TagerBlogConfig::getPostImageMobileScenario(),
                'content' => TagerBlogConfig::getPostContentScenario(),
                'openGraph' => TagerBlogConfig::getOpenGraphScenario(),
            ]
        ]);
    }
}
