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
    // REMOVE this line if user_id already exists:
    // $table->unsignedBigInteger('user_id')->nullable()->after('id');

    // Keep only the missing ones:
    if (!Schema::hasColumn('bookings', 'customer_name')) {
        $table->string('customer_name')->nullable();
    }

    if (!Schema::hasColumn('bookings', 'customer_email')) {
        $table->string('customer_email')->nullable();
    }

    if (!Schema::hasColumn('bookings', 'customer_phone')) {
        $table->string('customer_phone')->nullable();
    }

    if (!Schema::hasColumn('bookings', 'status')) {
        $table->string('status')->default('upcoming');
    }
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
    $table->dropColumn(['user_id', 'customer_name', 'customer_email', 'customer_phone', 'status']);
});

    }
};
