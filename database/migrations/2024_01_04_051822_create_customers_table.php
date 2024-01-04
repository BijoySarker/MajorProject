<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->enum('customer_type', ['General', 'Dealer', 'Corporate']);
            $table->string('registered_by');
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_postal_code')->nullable();
            $table->string('select_city');
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
        Schema::dropIfExists('customers');
    }
}
