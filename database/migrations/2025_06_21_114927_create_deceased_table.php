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
        Schema::create('deceased', function (Blueprint $table) {
            $table->id();
            $table->string('lot_image');
            $table->foreignId('lot_id')->constrained()->onDelete('cascade');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('suffix')->nullable();
            $table->string('gender');
            $table->string('birthday');
            $table->string('death_date');
            $table->string('death_certificate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deceased');
    }
};
