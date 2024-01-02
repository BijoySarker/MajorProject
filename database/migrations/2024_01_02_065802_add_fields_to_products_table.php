<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_quantity')->default(0);
            $table->text('product_specifications')->nullable();
            $table->string('product_image')->nullable();
            $table->json('product_gallery')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_quantity');
            $table->dropColumn('product_specifications');
            $table->dropColumn('product_image');
            $table->dropColumn('product_gallery');
        });
    }
}
