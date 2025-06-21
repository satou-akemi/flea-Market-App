<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityStreetAndBuildingToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('addresses', 'city')) {
                $table->string('city')->nullable();
            }
            if (!Schema::hasColumn('addresses', 'street')) {
                $table->string('street')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('addresses', 'street')) {
                $table->dropColumn('street');
            }
        });
    }
}
