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
        Schema::table('tags', function (Blueprint $table) {
            $table->string('imagekit_file_id')->nullable();
            $table->text('imagekit_url')->nullable();
            $table->text('imagekit_thumbnail_url')->nullable();
            $table->string('imagekit_file_path')->nullable();
            $table->integer('image_size')->nullable();
            $table->integer('original_image_size')->nullable();
            $table->integer('image_width')->nullable();
            $table->integer('image_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn([
                'imagekit_file_id',
                'imagekit_url',
                'imagekit_thumbnail_url',
                'imagekit_file_path',
                'image_size',
                'original_image_size',
                'image_width',
                'image_height',
            ]);
        });
    }
};
