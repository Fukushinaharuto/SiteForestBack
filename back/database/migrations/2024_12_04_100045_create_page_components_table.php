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
        Schema::create('page_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->string('type');
            $table->float('top');
            $table->float('left');
            $table->float('width');
            $table->float('height');
            $table->string('color');
            $table->string('unit');
            $table->integer('border');
            $table->string('border_color');
            $table->float('opacity');
            $table->float('angle');
            $table->integer('zIndex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_components');
    }
};
