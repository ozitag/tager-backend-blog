<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostFieldRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Pages\Models\TagerPage;

class ClonePostFieldsJob extends Job
{
    protected BlogPost $source;
    protected BlogPost $dest;

    public function __construct(BlogPost $source, BlogPost $dest)
    {
        $this->source = $source;

        $this->dest = $dest;
    }

    public function handle(PostFieldRepository $postFieldRepository)
    {
        foreach ($this->source->fields as $field) {
            $postFieldRepository->fillAndSave([
                'post_id' => $this->dest->id,
                'field' => $field->field,
                'value' => $field->value
            ]);
        }
    }
}
