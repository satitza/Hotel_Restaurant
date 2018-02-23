<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('hotels', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('hotel_name', 100);
            $table->integer('active')->unsigned();
            $table->foreign('active')->references('id')->on('actives')->onDelete('cascade');
            $table->text('hotel_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('hotels');
    }

}
