<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kiwi_urls', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('url')->index(); // Indexed column for storing URL
            $table->boolean('is_sync')->default(false); // Column to track sync status
            $table->timestamps(); // Optionally add created_at/updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kiwi_urls');
    }
};
