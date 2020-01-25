<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('make');
            $table->string('model');
            $table->string('location');
            $table->string('year');
            $table->string('transmission');
            $table->string('oil_filter')->nullable();
            $table->string('oil_engine')->nullable();
            $table->string('schedule_date');
            $table->float('amount', 8, 2);
            $table->string('payment_ref');
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->integer('is_deleted')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_ref')->references('reference')->on('payments');
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
        Schema::dropIfExists('orders');
    }
}
