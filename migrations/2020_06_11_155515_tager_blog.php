<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tager_blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('url_alias');
            $table->string('name');
            $table->string('page_title')->nullable();
            $table->text('page_description')->nullable();
            $table->unsignedBigInteger('open_graph_image_id')->nullable();

            $table->softDeletes();

            $table->foreign('open_graph_image_id')->references('id')->on('files');
        });

        Schema::create('tager_blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('url_alias');
            $table->string('title');
            $table->string('excerpt');
            $table->longText('body');
            $table->date('date')->nullable();
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('status');
            $table->string('page_title')->nullable();
            $table->text('page_description')->nullable();
            $table->unsignedBigInteger('open_graph_image_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('open_graph_image_id')->references('id')->on('files');
            $table->foreign('cover_image_id')->references('id')->on('files');
            $table->foreign('image_id')->references('id')->on('files');
        });

        Schema::create('tager_blog_post_categorids', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('post_id')->references('id')->on('tager_blog_posts');
            $table->foreign('category_id')->references('id')->on('tager_blog_categories');

            $table->primary(['post_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tager_blog_post_categorids');
        Schema::dropIfExists('tager_blog_posts');
        Schema::dropIfExists('tager_blog_categories');
    }
}
