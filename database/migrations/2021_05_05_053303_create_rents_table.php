<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_id')->unsigned();
            $table->string('invoice_number')->unique();
            $table->dateTime('book_datetime');
            $table->dateTime('payment_datetime');
            $table->dateTime('rent_datetime_start');
            $table->dateTime('rent_datetime_end');
            $table->dateTime('return_datetime');
            $table->enum('payment_status',['Belum Dibayar','Lunas']);
            $table->string('payment_file');
        });

        Schema::table('rents', function($table) {
            $table->foreign('cust_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}
