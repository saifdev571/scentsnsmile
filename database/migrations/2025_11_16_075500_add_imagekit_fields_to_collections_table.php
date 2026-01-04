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
        if (Schema::hasTable('collections')) {
            Schema::table('collections', function (Blueprint $table) {
                // ImageKit fields
                if (!Schema::hasColumn('collections', 'imagekit_file_id')) {
                    $table->string('imagekit_file_id')->nullable()->after('image');
                }
                if (!Schema::hasColumn('collections', 'imagekit_url')) {
                    $table->string('imagekit_url')->nullable()->after('imagekit_file_id');
                }
                if (!Schema::hasColumn('collections', 'imagekit_thumbnail_url')) {
                    $table->string('imagekit_thumbnail_url')->nullable()->after('imagekit_url');
                }
                if (!Schema::hasColumn('collections', 'imagekit_file_path')) {
                    $table->string('imagekit_file_path')->nullable()->after('imagekit_thumbnail_url');
                }
                if (!Schema::hasColumn('collections', 'image_size')) {
                    $table->integer('image_size')->nullable()->after('imagekit_file_path');
                }
                if (!Schema::hasColumn('collections', 'original_image_size')) {
                    $table->integer('original_image_size')->nullable()->after('image_size');
                }
                if (!Schema::hasColumn('collections', 'image_width')) {
                    $table->integer('image_width')->nullable()->after('original_image_size');
                }
                if (!Schema::hasColumn('collections', 'image_height')) {
                    $table->integer('image_height')->nullable()->after('image_width');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn([
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
