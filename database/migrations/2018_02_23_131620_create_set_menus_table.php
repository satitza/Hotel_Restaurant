<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetMenusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('set_menus', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            
            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            
            $table->integer('restaurant_id')->unsigned();
            $table->foreign('restaurant_id')->references('id')->on('hotels')->onDelete('cascade');
                       
            $table->string('menu_name', 100);
            $table->date('menu_date_start')->nullable();
            $table->date('menu_date_end')->nullable();
                                  
            $table->json('menu_date_select')->nullable();
            //$table->foreign('menu_date_select')->references('id')->on('days')->onDelete('cascade');
                      
            $table->string('menu_time_lunch_start', 50)->nullable();
            //$table->foreign('menu_time_lunch_start')->references('id')->on('time_lunch');
            
            $table->string('menu_time_lunch_end', 50)->nullable();//->unsigned();
            //$table->foreign('menu_time_lunch_end')->references('id')->on('time_lunch');
            
            $table->string('menu_time_dinner_start', 50)->nullable();
            //$table->foreign('menu_time_dinner_start')->references('id')->on('time_dinner');
            
            $table->string('menu_time_dinner_end', 50)->nullable();
            //$table->foreign('menu_time_dinner_end')->references('id')->on('time_dinner');
                       
            $table->double('menu_price', 8, 2)->nullable();
            $table->integer('menu_guest')->nullable();
                     
            $table->text('menu_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('set_menus');
    }

}
