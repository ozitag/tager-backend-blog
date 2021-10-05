<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use Ozerich\FileStorage\Rules\FileRule;
use OZiTAG\Tager\Backend\Blog\Rules\CategoryUrlPathRule;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Http\FormRequest;
use OZiTAG\Tager\Backend\Crud\Requests\CrudFormRequest;

/**
 *
 * @property int $parent
 * @property string $urlAlias
 * @property string $name
 * @property bool $isDefault
 * @property string $pageTitle
 * @property string $pageDescription
 * @property int $openGraphImage
 * @property string $language
 */
class CreateBlogCategoryRequest extends CrudFormRequest
{
    public function fileScenarios()
    {
        return [
            'openGraphImage' => TagerBlogConfig::getOpenGraphScenario()
        ];
    }

    public function rules()
    {
        $result = [
            'parent' => ['nullable', 'integer', 'exists:tager_blog_categories,id,id,!0,deleted_at,NULL'],
            'urlAlias' => ['required', 'string', new CategoryUrlPathRule($this->route('id'), $this->language)],
            'name' => 'required|string',
            'isDefault' => 'required|boolean',
            'pageTitle' => 'string|nullable',
            'pageDescription' => 'string|nullable',
            'openGraphImage' => ['nullable', new FileRule()],
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $result['language'] = 'required|string|in:' . implode(',', TagerBlogConfig::getLanguageIds());
        }

        return $result;
    }
}
