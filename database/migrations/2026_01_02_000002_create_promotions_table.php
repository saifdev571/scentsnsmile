<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Discount settings
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);
            
            // Conditions
            $table->integer('min_items')->default(1)->comment('Minimum items required');
            $table->decimal('min_amount', 10, 2)->default(0)->comment('Minimum cart amount');
            
            // Free shipping
            $table->boolean('free_shipping')->default(false);
            $table->integer('free_shipping_min_items')->nullable();
            
            // Display settings
            $table->string('badge_text')->nullable()->comment('Text shown on header badge');
            $table->string('badge_color')->default('#ef4444')->comment('Badge background color');
            $table->string('banner_title')->nullable()->comment('Title for promo banner');
            $table->string('banner_subtitle')->nullable();
            $table->string('cart_label')->nullable()->comment('Label shown in cart discount');
            
            // Validity
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_header')->default(true);
            $table->boolean('show_in_cart')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
