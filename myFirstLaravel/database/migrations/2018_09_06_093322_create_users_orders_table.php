<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orders_id');
            $table->integer('users_id');
            $table->integer('menus_id');
            $table->char('size',1);
            $table->integer('memo')->nullable()->comment('備註');//備註
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
        Schema::dropIfExists('users_orders');
    }
}