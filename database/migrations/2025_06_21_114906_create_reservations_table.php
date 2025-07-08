<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->enum('status', ['pending', 'paid', 'expired', 'cancel'])->default('pending');

            $table->foreignId('lot_id')->constrained()->onDelete('cascade');

            // This references the user who made the reservation
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('total_downpayment_price', 15, 2);
            $table->string('proof_of_payment');
            $table->string('remarks')->nullable();

            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('approved_date')->nullable();

            // This references the user who approved the reservation
            $table->foreignId('approved_id')->nullable()->constrained('users')->onDelete('cascade')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
