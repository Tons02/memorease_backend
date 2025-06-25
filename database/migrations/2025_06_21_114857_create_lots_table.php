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
            $table->string('lot_number');
            $table->json('bounds');
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->dateTime('reserved_until')->nullable();
            $table->decimal('price', 7, 2);
            $table->decimal('promo_price', 7, 2);
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
