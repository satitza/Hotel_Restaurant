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
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            $table->string('menu_name', 100);
            $table->string('image', 100);

            $table->date('menu_date_start')->nullable();
            $table->date('menu_date_end')->nullable();

            $table->longText('menu_date_select')->nullable();

            $table->string('menu_time_lunch_start', 50)->nullable();
            $table->string('menu_time_lunch_end', 50)->nullable();

            $table->string('menu_time_dinner_start', 50)->nullable();
            $table->string('menu_time_dinner_end', 50)->nullable();

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
