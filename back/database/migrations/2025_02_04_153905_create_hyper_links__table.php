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
        Schema::create('hyper_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_id')->unique()->constrained()->onDelete('cascade');
            $table->string('href');
            $table->enum('is_link', ['text', 'back', 'no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hyper_links');
    }
};
