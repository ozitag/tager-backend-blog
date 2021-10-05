<?php

namespace OZiTAG\Tager\Backend\Blog\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class CategoryUrlPathRule implements Rule
{
    protected ?int $id = null;

    protected ?string $language = null;

    protected ?string $value = null;

    public function __construct(?int $id = null, ?string $language = null)
    {
        $this->id = $id;

        $this->language = $language;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param string $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;
        $path = preg_replace('#\/+$#si', '', $value);
        if (empty($path)) {
            $path = '/';
        }

        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        /** @var CategoryRepository $repository */
        $repository = App::make(CategoryRepository::class);

        $existedPage = $repository->getByAlias($path, $this->language);

        if ($this->id === null) {
            return $existedPage === null;
        } else {
            return $existedPage === null || $existedPage->id == $this->id;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('tager-blog::errors.category_url_busy', ['url_path' => $this->value]);
    }
}
