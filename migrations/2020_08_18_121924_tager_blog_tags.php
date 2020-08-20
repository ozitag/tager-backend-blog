<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tager_blog_tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');

            $table->unique('tag');
        });

        Schema::create('tager_blog_post_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('post_id')->references('id')->on('tager_blog_posts');
            $table->foreign('tag_id')->references('id')->on('tager_blog_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tager_blog_post_tags');
        Schema::dropIfExists('tager_blog_tags');
    }
}
