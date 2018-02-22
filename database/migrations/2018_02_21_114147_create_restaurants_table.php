<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('restaurant_name', 100);
            $table->integer('hotel_id')->unsigned(); 
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->integer('active')->unsigned();
            $table->foreign('active')->references('id')->on('actives')->onDelete('cascade');
            $table->text('restaurant_comment')->nullable();
            $table->timestamps();
            
            
            //$table->foreign('active')->references('id')->on('actives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
