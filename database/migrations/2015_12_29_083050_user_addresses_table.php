<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');
            $table->string('contact_name')->nullable();
            $table->string('contact_phone', 11)->nullable();
            $table->string('name');
            $table->string('street');
            $table->string('city');
            $table->boolean('is_default')->default(0);
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
        Schema::drop('user_addresses');
    }
}
