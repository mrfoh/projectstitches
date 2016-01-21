<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVendorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_profiles', function($table) {
            $table->string('facebook')->nullable()->after('addresses');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('instagram')->nullable()->after('twitter');
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
