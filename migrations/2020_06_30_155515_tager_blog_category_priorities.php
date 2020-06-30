<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogCategoryPriorities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->unsignedInteger('priority')->nullable();
        });

        $items = DB::select('select id from tager_blog_categories');
        foreach ($items as $ind => $item) {
            DB::update('update tager_blog_categories set `priority` = ? where id = ?', [$ind + 1, $item->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_blog_categories', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
}
