<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rent_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('item_qty');
            $table->integer('rent_item_price');

        });

        Schema::table('rent_details', function($table) {
            $table->foreign('rent_id')->references('id')->on('rents');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_details');
    }
}
