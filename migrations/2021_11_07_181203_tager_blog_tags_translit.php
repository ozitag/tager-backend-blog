<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagerBlogTagsTranslit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tager_blog_tags', function (Blueprint $table) {
            $table->string('url_alias');
        });

        $items = \Illuminate\Support\Facades\DB::table('tager_blog_tags')->get();
        foreach($items as $item){
           \Illuminate\Support\Facades\DB::table('tager_blog_tags')->where('id', $item->id)->update([
               'url_alias' => \OZiTAG\Tager\Backend\Utils\Helpers\Translit::translit($item->tag)
           ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tager_blog_tags', function (Blueprint $table) {
            $table->dropColumn('url_alias');
        });
    }
}
