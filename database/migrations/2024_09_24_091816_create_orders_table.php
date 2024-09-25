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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Link to the users table
            $table->foreignId('checkout_id')->nullable()->constrained('checkouts')->onDelete('set null'); // Link to checkout, if applicable
            $table->decimal('total_amount', 10, 2); // Total order amount
            $table->string('mpesa_code')->nullable(); // MPesa transaction code
            $table->string('payment_status')->default('Pending'); 
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
        Schema::dropIfExists('orders');
    }
};
