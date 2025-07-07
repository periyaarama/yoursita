<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('past_bookings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('service');
        $table->decimal('price', 8, 2);
        $table->integer('quantity');
        $table->string('name')->nullable();
        $table->string('phoneNumber')->nullable();
        $table->string('address')->nullable();
        $table->string('state')->nullable();
        $table->string('city')->nullable();
        $table->string('postcode')->nullable();
        $table->date('selectedDate')->nullable();
        $table->string('selectedTime')->nullable();
        $table->string('notes')->nullable();
        $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('past_bookings');
    }
};
