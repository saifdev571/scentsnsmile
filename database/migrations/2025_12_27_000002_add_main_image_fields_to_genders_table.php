<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->string('main_image')->nullable()->after('thumb_image');
            $table->string('main_imagekit_file_id')->nullable()->after('main_image');
            $table->text('main_imagekit_url')->nullable()->after('main_imagekit_file_id');
            $table->text('main_imagekit_thumbnail_url')->nullable()->after('main_imagekit_url');
            $table->string('main_imagekit_file_path')->nullable()->after('main_imagekit_thumbnail_url');
            $table->integer('main_image_size')->nullable()->after('main_imagekit_file_path');
            $table->integer('main_original_image_size')->nullable()->after('main_image_size');
            $table->integer('main_image_width')->nullable()->after('main_original_image_size');
            $table->integer('main_image_height')->nullable()->after('main_image_width');
        });
    }

    public function down(): void
    {
        Schema::table('genders', function (Blueprint $table) {
            $table->dropColumn([
                'main_image',
                'main_imagekit_file_id',
                'main_imagekit_url',
                'main_imagekit_thumbnail_url',
                'main_imagekit_file_path',
                'main_image_size',
                'main_original_image_size',
                'main_image_width',
                'main_image_height'
            ]);
        });
    }
};
