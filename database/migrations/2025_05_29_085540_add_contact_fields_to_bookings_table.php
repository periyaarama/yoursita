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
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('name')->nullable();
        $table->string('phoneNumber')->nullable();
        $table->string('postcode')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['name', 'phoneNumber', 'postcode', 'city', 'state']);
    });
}
};
