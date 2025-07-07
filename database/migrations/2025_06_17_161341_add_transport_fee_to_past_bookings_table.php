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
    Schema::table('past_bookings', function (Blueprint $table) {
        $table->decimal('transport_fee', 8, 2)->default(0)->after('full_payment');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('past_bookings', function (Blueprint $table) {
        $table->dropColumn('transport_fee');
    });
}
};
