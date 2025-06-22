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
        Schema::create('cemeteries', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('location');
            $table->string('description');
            $table->string('profile_picture');
            $table->string(column: 'background_picture');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cemeteries');
    }
};
