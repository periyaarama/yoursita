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
    Schema::create('services', function (Blueprint $table) {
        $table->id('serviceID');
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 8, 2);
        $table->string('image')->nullable(); // for uploaded image file path
        $table->timestamps(); // created_at, updated_at
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::dropIfExists('services');
}

};
