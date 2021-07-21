<?php

namespace OZiTAG\Tager\Backend\Blog\Console;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Console\Command;
use OZiTAG\Tager\Backend\Mail\Repositories\MailTemplateRepository;

class FlushBlogUpdateFileScenariosCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tager:blog-update-file-scenarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush blog';

    public function handle(PostRepository $repository, Storage $fileStorage)
    {
        /** @var BlogPost[] $posts */
        $posts = $repository->all();
        $this->log('Found ' . count($posts) . ' posts');

        foreach ($posts as $ind => $post) {
            $this->log('Post ' . ($ind + 1) . '/' . count($posts) . ', ID ' . $post->id . ' - ', false);

            if ($post->cover_image_id) {
                $fileStorage->setFileScenario($post->cover_image_id, TagerBlogConfig::getPostCoverScenario());
            }
            if ($post->image_id) {
                $fileStorage->setFileScenario($post->image_id, TagerBlogConfig::getPostImageScenario());
            }
            if ($post->mobile_image_id) {
                $fileStorage->setFileScenario($post->mobile_image_id, TagerBlogConfig::getPostImageMobileScenario());
            }
            if ($post->open_graph_image_id) {
                $fileStorage->setFileScenario($post->open_graph_image_id, TagerBlogConfig::getOpenGraphScenario());
            }

            $this->log('OK');
        }
    }
}
