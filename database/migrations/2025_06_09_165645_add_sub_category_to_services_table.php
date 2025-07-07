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
    Schema::table('services', function (Blueprint $table) {
        $table->string('sub_category')->nullable(); // 'hand' or 'leg'
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('services', function (Blueprint $table) {
        $table->dropColumn('sub_category');
    });
}
};
