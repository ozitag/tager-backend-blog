<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Blog\Models\BlogTag;
use OZiTAG\Tager\Backend\Blog\Repositories\PostFieldRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRelatedPostRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostTagRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\TagRepository;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

class SetPostAdditionalFieldsJob extends Job
{
    private $post;

    private $fields;

    public function __construct(BlogPost $post, $fields)
    {
        $this->post = $post;
        $this->fields = $fields;
    }

    public function handle(PostFieldRepository $postFieldRepository)
    {
        $postFieldRepository->deleteByPostId($this->post->id);

        if (!$this->fields) {
            return;
        }

        foreach ($this->fields as $field) {
            if (!isset($field['name']) || !isset($field['value'])) continue;

            $fieldName = $field['name'];
            $fieldConfig = TagerBlogConfig::getPostAdditionalField($fieldName);
            if (!$fieldConfig) continue;

            $fieldModel = FieldFactory::create($fieldConfig['type'], null, $fieldConfig['meta']);
            $type = $fieldModel->getTypeInstance();
            $type->setValue($field['value']);

            $postFieldRepository->create([
                'post_id' => $this->post->id,
                'field' => $fieldName,
                'value' => $type->getDatabaseValue()
            ]);
        }
    }
}
