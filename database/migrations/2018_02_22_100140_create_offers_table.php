<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');

            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');

            $table->integer('restaurant_id')->unsigned();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');

            //$table->string('image', 100)->nullable();
            $table->string('attachments', 100)->nullable();

            $table->string('offer_name_th', 100)->nullable();
            $table->string('offer_name_en', 100)->nullable();
            $table->string('offer_name_cn', 100)->nullable();

            $table->date('offer_date_start')->nullable();
            $table->date('offer_date_end')->nullable();

            $table->longText('offer_day_select')->nullable();

            $table->string('offer_time_lunch_start', 50)->nullable();
            $table->string('offer_time_lunch_end', 50)->nullable();
            $table->double('offer_lunch_price', 8, 2)->unsigned();
            $table->integer('offer_lunch_guest')->unsigned();


            $table->string('offer_time_dinner_start', 50)->nullable();
            $table->string('offer_time_dinner_end', 50)->nullable();
            $table->double('offer_dinner_price', 8, 2)->unsigned();
            $table->integer('offer_dinner_guest')->unsigned();

            $table->text('offer_short_th')->nullable();
            $table->text('offer_short_en')->nullable();
            $table->text('offer_short_cn')->nullable();

            $table->text('offer_comment_th')->nullable();
            $table->text('offer_comment_en')->nullable();
            $table->text('offer_comment_cn')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
