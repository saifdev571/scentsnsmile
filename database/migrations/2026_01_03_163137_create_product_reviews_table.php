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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name')->nullable(); // For guest users
            $table->string('email')->nullable(); // For guest users
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->string('title')->nullable();
            $table->text('comment');
            $table->json('images')->nullable(); // Array of image URLs
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false); // Admin moderation
            $table->integer('helpful_count')->default(0);
            $table->timestamps();

            // Indexes for performance
            $table->index('product_id');
            $table->index('user_id');
            $table->index('is_approved');
            $table->index('rating');
            $table->index('created_at');
        });

        Schema::create('review_helpful', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('product_reviews')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->nullable();

            // Prevent duplicate helpful marks
            $table->unique(['review_id', 'ip_address']);
            
            // Indexes
            $table->index('review_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_helpful');
        Schema::dropIfExists('product_reviews');
    }
};
