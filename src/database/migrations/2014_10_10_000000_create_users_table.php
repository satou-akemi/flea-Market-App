<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_name',100)->nullable();
            $table->string('email',100)->unique();
            $table->string('avatar')->nullable();
            $table->string('password',100);
            $table->string('profile_img')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('billing_address_prefecture')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_street')->nullable();
            $table->string('billing_address_postal_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
