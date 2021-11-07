<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Blog\Models\BlogTag;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRelatedPostRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostTagRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\TagRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Utils\Helpers\Translit;

class SetPostTagsJob extends Job
{
    private $post;

    private $tags;

    /** @var TagRepository */
    private $tagRepository;

    public function __construct(BlogPost $post, $tags)
    {
        $this->post = $post;
        $this->tags = $tags;

        $this->tagRepository = App::make(TagRepository::class);
    }

    /**
     * @param string $tag
     * @return BlogTag
     */
    private function getTagModel($tag)
    {
        $tag = trim($tag);

        $model = $this->tagRepository->getByTag($tag);
        if (!$model) {
            $this->tagRepository->reset();
            $model = $this->tagRepository->fillAndSave([
                'tag' => $tag,
                'url_alias' => Translit::translit($tag)
            ]);
        }

        return $model;
    }

    /**
     * @return BlogTag[]
     */
    private function getTagModels()
    {
        $result = [];
        $added = [];

        foreach ($this->tags as $tag) {
            $model = $this->getTagModel($tag);

            if (!$model) {
                continue;
            }

            if (!in_array($model->id, $added)) {
                $added[] = $model->id;
                $result[] = $model;
            }
        }

        return $result;
    }

    public function handle(PostTagRepository $postTagRepository)
    {
        $postTagRepository->deleteByPostId($this->post->id);

        if (!$this->tags) {
            return;
        }

        $tags = $this->getTagModels();

        foreach ($tags as $tag) {
            $postTagRepository->create([
                'post_id' => $this->post->id,
                'tag_id' => $tag->id
            ]);
        }
    }
}
