<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogNestedCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->nestedSet();
        });

        $ind = 1;
        $rows = \Illuminate\Support\Facades\DB::select('SELECT id FROM tager_blog_categories ORDER BY priority');
        foreach ($rows as $row) {
            \Illuminate\Support\Facades\DB::update('UPDATE tager_blog_categories SET _lft = ' . ($ind++) . ', _rgt=' . ($ind++) . ' WHERE id = ' . $row->id);
        }

        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->dropColumn('priority');
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
            $table->integer('priority')->nullable();
            $table->dropNestedSet();
        });
    }
}
