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
            $table->integer('row');
            $table->integer('column');

            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->dateTime('reserved_until')->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->foreignId('section_id')->constrained()->onDelete('cascade');

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
