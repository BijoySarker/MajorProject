<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number');
            $table->unsignedBigInteger('product_id');
            $table->longText('terms_and_condition')->nullable();
            $table->integer('quantity');
            $table->string('product_price');
            $table->integer('quotation_type')->comment('0 for dealer, 1 for corporate');
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('quotation_subject')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->string('company_persons')->nullable();
            $table->string('attention_quot')->nullable();
            $table->string('dear_sir')->nullable();
            $table->longText('quotation_body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
