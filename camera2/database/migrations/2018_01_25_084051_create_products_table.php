<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('price');
            $table->mediumText('description')->nullable();
            $table->text('detail')->nullable();
            $table->text('guide')->nullable();
            $table->string('guarantee')->nullable();
            $table->integer('total_views')->default(0);
            $table->string('image')->nullable();
            $table->string('status')->default(\App\Models\Product::STATUS_SHOW);
            $table->integer('prioty')->default(0);
            $table->integer('category_id')->unsigned();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
