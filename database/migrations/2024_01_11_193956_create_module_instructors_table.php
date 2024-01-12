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
        Schema::create('modules_instructor', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
            $table->foreignId('modules_id')->constrained('modules');
            $table->foreignId('instructor_id')->constrained('instructors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules_instructor');
    }
};
