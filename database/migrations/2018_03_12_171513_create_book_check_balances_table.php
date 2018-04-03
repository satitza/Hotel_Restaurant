<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCheckBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_check_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_menu_id')->unsigned();
            $table->foreign('book_menu_id')->references('id')->on('offers')->onDelete('cascade');
            $table->date('book_menu_date')->nullable();
            $table->integer('book_menu_guest')->nullable();
            $table->integer('book_menu_balance')->nullable();
            $table->integer('active_id')->unsigned();
            $table->foreign('active_id')->references('id')->on('actives')->onDelete('cascade');
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
        Schema::dropIfExists('book_check_balances');
    }
}
