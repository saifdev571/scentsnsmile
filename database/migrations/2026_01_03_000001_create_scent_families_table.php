<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scent_families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('imagekit_file_id')->nullable();
            $table->text('imagekit_url')->nullable();
            $table->text('imagekit_thumbnail_url')->nullable();
            $table->string('imagekit_file_path', 500)->nullable();
            $table->unsignedInteger('image_size')->nullable();
            $table->unsignedInteger('original_image_size')->nullable();
            $table->unsignedInteger('image_width')->nullable();
            $table->unsignedInteger('image_height')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

        Schema::create('product_scent_family', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('scent_family_id');
            $table->timestamps();

            $table->index('product_id');
            $table->index('scent_family_id');
            $table->unique(['product_id', 'scent_family_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_scent_family');
        Schema::dropIfExists('scent_families');
    }
};
