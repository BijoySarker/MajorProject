<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_children', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image')->nullable(); // Add this line for the image field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_children', function (Blueprint $table) {
            // $table->dropColumn(['status', 'image']);
        });
    }
}