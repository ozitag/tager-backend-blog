<?php

namespace OZiTAG\Tager\Backend\Blog\Console;

use OZiTAG\Tager\Backend\Blog\Jobs\ArchivePostJob;
use OZiTAG\Tager\Backend\Blog\Jobs\PublishPostJob;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Console\Command;

class UpdateTagerBlogPostStatusesCommand extends Command
{
    public $signature = 'cron:tager-blog:update-post-statuses';

    public function handle(PostRepository $postRepository)
    {
        /** @var BlogPost[] $draftPosts */
        $draftPosts = $postRepository->queryDraft()->whereNotNull('publish_at')->get();
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
        $publishedPosts = $postRepository->queryPublished()->whereNotNull('archive_at')->get();
        foreach ($publishedPosts as $publishedPost) {
            $this->log('Check Published Post #' . $draftPost->id . ': ', false);
            if (time() >= strtotime($draftPost->archive_at)) {
                $this->runJob(ArchivePostJob::class, ['model' => $draftPost]);
                $this->log('Archive');
            } else {
                $this->log('Skip');
            }
        }
    }
}
