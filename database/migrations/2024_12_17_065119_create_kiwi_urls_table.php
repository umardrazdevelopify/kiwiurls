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
            $table->id();
            $table->string('url')->index();  // This will store the URLs
            $table->boolean('is_sync')->default(false);  // Flag for syncing
            $table->timestamps();
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
