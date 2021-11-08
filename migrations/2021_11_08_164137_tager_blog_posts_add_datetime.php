<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogPostsAddDatetime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->renameColumn('date', 'datetime');
        });

        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->datetime('datetime')->nullable()->change();
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
            $table->date('datetime')->nullable()->change();
        });

        Schema::table('tager_blog_posts', function (Blueprint $table) {
            $table->renameColumn('datetime', 'date');
        });
    }
}
