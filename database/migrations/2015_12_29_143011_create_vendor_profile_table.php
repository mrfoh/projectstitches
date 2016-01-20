<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_profiles', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('profile_photo')->nullable();
            $table->text('phones')->nullable(); //json
            $table->text('addresses')->nullable(); //json
            $table->text('social')->nullable();
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
        Schema::drop('vendor_profiles');
    }
}
