<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');

            $table->string('booking_id', 100);

            $table->integer('booking_hotel_id')->unsigned();
            $table->foreign('booking_hotel_id')->references('id')->on('hotels')->onDelete('cascade');

            $table->integer('booking_restaurant_id')->unsigned();
            $table->foreign('booking_restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');

            $table->integer('booking_offer_id')->unsigned();
            $table->foreign('booking_offer_id')->references('id')->on('offers')->onDelete('cascade');

            $table->date('booking_date')->nullable();
            $table->integer('booking_guest')->unsigned();

            $table->string('booking_contact_title', 100);
            $table->string('booking_contact_firstname', 100);
            $table->string('booking_contact_lastname', 100);
            $table->string('booking_contact_email', 100);
            $table->string('booking_contact_phone', 100);
            $table->string('booking_contact_request', 100);

            $table->integer('booking_status')->unsigned();
            $table->foreign('booking_status')->references('id')->on('booking_statuses')->onDelete('cascade');

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
        Schema::dropIfExists('reports');
    }
}
