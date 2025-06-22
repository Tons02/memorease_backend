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
            $table->foreignId('lot_id')->constrained()->onDelete('cascade');
            $table->string('fname');
            $table->string('mi');
            $table->string('lname');
            $table->string('suffix');
            $table->string(column: 'gender');
            $table->string(column: 'birthday');
            $table->string(column: 'death_date');
            $table->string(column: 'burial_date');
            $table->string(column: 'death_certificate');
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
