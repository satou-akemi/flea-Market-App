<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('order_date');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status')->nullable();
            $table->foreignId('address_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('payment_id')->nullable(); // ★外部キー制約は後で貼る
            $table->string('order_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
