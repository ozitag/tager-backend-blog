<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->string('language')->nullable();
        });

        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->string('language')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
}
