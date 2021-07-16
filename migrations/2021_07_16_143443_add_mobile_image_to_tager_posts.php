<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileImageToTagerPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('mobile_image_id')->nullable()->after('image_id');
            $table->foreign('mobile_image_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->dropColumn('mobile_image_id');
        });
    }
}
