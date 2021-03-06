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
            $table->foreign('booking_hotel_id')->references('id')->on('hotels');

            $table->integer('booking_restaurant_id')->unsigned();
            $table->foreign('booking_restaurant_id')->references('id')->on('restaurants');

            $table->integer('booking_offer_id')->unsigned();
            $table->foreign('booking_offer_id')->references('id')->on('offers');

            $table->date('booking_date')->nullable();
            $table->string('booking_time', 10);
            $table->integer('booking_guest')->unsigned();

            $table->string('booking_contact_title', 100);
            $table->string('booking_contact_firstname', 100);
            $table->string('booking_contact_lastname', 100);
            $table->string('booking_contact_email', 100);
            $table->string('booking_contact_phone', 100);
            $table->string('booking_contact_request', 100);

            $table->float('booking_price', 8, 2)->unsigned();

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->integer('rate_suffix_id')->unsigned();
            $table->foreign('rate_suffix_id')->references('id')->on('rate_suffixes');

            $table->string('booking_time_type', 100);
            $table->string('booking_voucher', 10)->nullable();

            $table->integer('booking_status')->unsigned();
            $table->foreign('booking_status')->references('id')->on('booking_statuses');

            $table->string('usage_status', 10)->nullable();

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
