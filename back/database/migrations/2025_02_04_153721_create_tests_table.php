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
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_component_id')->unique()->constrained('page_components')->onDelete('cascade');
            $table->string('text_color');
            $table->integer('size');
            $table->string('font');
            $table->string('children');
            $table->enum('text_align', ['left', 'center', 'right']);
            $table->enum('vertical_align', ['top', 'middle', 'bottom']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
