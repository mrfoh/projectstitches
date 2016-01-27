<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function($table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->integer('product_id');
            $table->enum('name', ['color','size','material']);
            $table->string('value');
            $table->float('price')->nullable();
            $table->integer('qty')->nullable();
            $table->boolean('track')->default(0);
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
        Schema::drop('variants');
    }
}
