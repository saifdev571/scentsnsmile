<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
            $table->string('imagekit_file_id')->nullable()->after('image');
            $table->text('imagekit_url')->nullable()->after('imagekit_file_id');
            $table->text('imagekit_thumbnail_url')->nullable()->after('imagekit_url');
            $table->string('imagekit_file_path')->nullable()->after('imagekit_thumbnail_url');
            $table->integer('image_size')->nullable()->after('imagekit_file_path');
            $table->integer('original_image_size')->nullable()->after('image_size');
            $table->integer('image_width')->nullable()->after('original_image_size');
            $table->integer('image_height')->nullable()->after('image_width');
        });
    }

    public function down(): void
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'imagekit_file_id',
                'imagekit_url',
                'imagekit_thumbnail_url',
                'imagekit_file_path',
                'image_size',
                'original_image_size',
                'image_width',
                'image_height'
            ]);
        });
    }
};
