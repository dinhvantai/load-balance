<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditStatusAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('status')->default(\App\Models\Category::STATUS_SHOW);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status')->default(\App\Models\Product::STATUS_SHOW);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('status')->default(\App\Models\Post::STATUS_SHOW);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->boolean('status')->default(\App\Models\Banner::STATUS_SHOW);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
