<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table) {

            $table->increments('id');
            $table->string('no')->unique();
            $table->integer('user_id');
            $table->integer('vendor_id');
            $table->text('notes')->nullable();
            $table->boolean('paid')->default(0);
            $table->string('payment_method');
            $table->enum('status', ['pending','tailoring','shipped','delivered','cancelled'])
                  ->default('pending');
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
        Schema::drop('orders');
    }
}
