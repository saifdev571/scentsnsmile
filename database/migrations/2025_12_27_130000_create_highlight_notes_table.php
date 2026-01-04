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
        Schema::create('highlight_notes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            // ImageKit fields
            $table->string('imagekit_file_id')->nullable();
            $table->string('imagekit_url')->nullable();
            $table->string('imagekit_thumbnail_url')->nullable();
            $table->string('imagekit_file_path')->nullable();
            $table->integer('image_size')->nullable();
            $table->integer('original_image_size')->nullable();
            $table->integer('image_width')->nullable();
            $table->integer('image_height')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for product-highlight_note relationship
        Schema::create('product_highlight_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('highlight_note_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['product_id', 'highlight_note_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_highlight_note');
        Schema::dropIfExists('highlight_notes');
    }
};
