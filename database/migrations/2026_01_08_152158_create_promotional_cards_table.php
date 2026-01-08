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
        Schema::create('promotional_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Internal Admin Name');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('media_url'); // ImageKit URL
            $table->string('thumbnail_url')->nullable(); // For videos

            // Content
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            // Styling & Position
            $table->integer('position')->default(0)->comment('Grid index position (0-based)');
            $table->string('text_color')->default('dark'); // dark, light
            $table->string('background_color')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotional_cards');
    }
};
