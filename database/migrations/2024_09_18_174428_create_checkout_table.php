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
        Schema::create('checkout', function (Blueprint $table) {
            $table->id();
            $table->string('ride_name')->nullable();
            $table->string('ride_area')->nullable();
            $table->string('ride_neighborhood')->nullable();
            $table->string('ride_apartment')->nullable();
            $table->string('ride_destination')->nullable();
            $table->string('pickup_name')->nullable();
            $table->string('pickup_destination')->nullable();
            $table->string('past_name')->nullable();
            $table->string('past_area')->nullable();
            $table->string('past_destination')->nullable();
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
        Schema::dropIfExists('checkout');
    }
};
