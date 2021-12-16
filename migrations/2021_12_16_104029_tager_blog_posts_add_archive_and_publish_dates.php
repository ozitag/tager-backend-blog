<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogPostsAddArchiveAndPublishDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_posts', function(Blueprint $table){
            $table->dateTime('archive_at')->nullable()->after('status');
        });

        Schema::table('tager_blog_posts', function(Blueprint $table){
            $table->dateTime('publish_at')->nullable()->after('archive_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_blog_posts', function(Blueprint $table){
            $table->dropColumn(['archive_at', 'publish_at']);
        });
    }
}
