<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('voucher_booking_id');
            $table->string('voucher_contact_title', 100);
            $table->string('voucher_contact_firstname', 100);
            $table->string('voucher_contact_lastname', 100);
            $table->string('voucher_contact_email', 100);
            $table->string('voucher_contact_phone', 100);
            $table->string('voucher_contact_request', 100);

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
        Schema::dropIfExists('vouchers');
    }
}
