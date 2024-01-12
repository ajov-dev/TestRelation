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
        Schema::create('modules_themes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
            $table->foreignId('modules_id')->constrained('modules');
            $table->foreignId('themes_id')->constrained('themes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules_themes');
    }
};
