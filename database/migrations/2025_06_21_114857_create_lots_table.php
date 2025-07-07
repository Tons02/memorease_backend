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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('lot_image');
            $table->string('lot_number');
            $table->string('description');
            $table->json('coordinates');
            $table->enum('status', ['available', 'reserved', 'occupied', 'sold'])->default('available');
            $table->dateTime('reserved_until')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('downpayment_price', 15, 2)->nullable();
            $table->decimal('promo_price', 15, 2)->nullable();
            $table->date('promo_until')->nullable();
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
