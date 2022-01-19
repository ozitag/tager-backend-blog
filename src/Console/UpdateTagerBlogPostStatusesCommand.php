<?php

namespace OZiTAG\Tager\Backend\Blog\Console;

use OZiTAG\Tager\Backend\Blog\Jobs\ArchivePostJob;
use OZiTAG\Tager\Backend\Blog\Jobs\PublishPostJob;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Cron\Console\CronCommand;

class UpdateTagerBlogPostStatusesCommand extends CronCommand
{
    public $signature = 'cron:tager-blog:update-post-statuses';

    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    public function handle()
    {
        /** @var BlogPost[] $draftPosts */
        $draftPosts = $this->postRepository->queryDraft()->whereNotNull('publish_at')->get();
        foreach ($draftPosts as $draftPost) {
            $this->log('Check Draft Post #' . $draftPost->id . ': ', false);
            if (time() >= strtotime($draftPost->publish_at)) {
                $this->runJob(PublishPostJob::class, ['model' => $draftPost]);
                $this->log('Publish');
            } else {
                $this->log('Skip');
            }
        }

        /** @var BlogPost[] $publishedPosts */
        $publishedPosts = $this->postRepository->queryPublished()->whereNotNull('archive_at')->get();
        foreach ($publishedPosts as $publishedPost) {
            $this->log('Check Published Post #' . $publishedPost->id . ': ', false);
            if (time() >= strtotime($publishedPost->archive_at)) {
                $this->runJob(ArchivePostJob::class, ['model' => $publishedPost]);
                $this->log('Archive');
            } else {
                $this->log('Skip');
            }
        }
    }
}
