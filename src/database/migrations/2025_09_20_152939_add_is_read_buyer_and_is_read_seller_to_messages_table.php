<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadBuyerAndIsReadSellerToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
        $table->boolean('is_read_buyer')->default(false);
        $table->boolean('is_read_seller')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('is_read_buyer');
        $table->dropColumn('is_read_seller');
        });
    }
}
