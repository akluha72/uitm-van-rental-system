<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->date('payment_date');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method'); // E.g., Credit Card, PayPal
            $table->string('payment_status')->default('Successful'); // E.g., Successful, Failed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
