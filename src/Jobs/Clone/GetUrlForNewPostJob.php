<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetUrlForNewPostJob extends Job
{
    protected string $currentUrl;
    protected ?string $language;

    public function __construct(string $currentUrl, ?string $language)
    {
        $this->currentUrl = $currentUrl;
        $this->language = $language;
    }

    public function handle(PostRepository $repository)
    {
        $ind = 0;
        while (true) {
            $url = $this->currentUrl . '-copy';
            if ($ind > 0) {
                $url .= '-' . $ind;
            }

            if ($repository->getByAlias($url, $this->language) === null) {
                return $url;
            }

            $ind = $ind + 1;
        }
    }
}
