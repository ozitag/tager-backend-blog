<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Pages\Models\TagerPage;

class CloneBasicPostJob extends Job
{
    protected BlogPost $model;

    protected string $newUrl;

    public function __construct(BlogPost $model, string $newUrl)
    {
        $this->model = $model;
        $this->newUrl = $newUrl;
    }

    public function handle(Storage $storage)
    {
        $newPost = new BlogPost();

        $newPost->title = $this->model->title.' (Copy)';
        $newPost->url_alias = $this->newUrl;
        $newPost->excerpt = $this->model->excerpt;
        $newPost->body = $this->model->body;
        $newPost->datetime = $this->model->datetime;
        $newPost->status = $this->model->status;
        $newPost->page_title = $this->model->page_title;
        $newPost->page_description = $this->model->page_description;
        $newPost->language = $this->model->language;

        if ($this->model->image_id) {
            $newPost->image_id = $storage->clone($this->model->image_id);
        }

        if ($this->model->cover_image_id) {
            $newPost->cover_image_id = $storage->clone($this->model->cover_image_id);
        }

        if ($this->model->mobile_image_id) {
            $newPost->mobile_image_id = $storage->clone($this->model->mobile_image_id);
        }

        if ($this->model->open_graph_image_id) {
            $newPost->open_graph_image_id = $storage->clone($this->page->open_graph_image_id);
        }

        $newPost->save();

        return $newPost;
    }
}
