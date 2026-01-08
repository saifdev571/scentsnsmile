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
        Schema::table('products', function (Blueprint $table) {
            // Add new display flags
            if (!Schema::hasColumn('products', 'is_bestseller')) {
                $table->boolean('is_bestseller')->default(false)->after('featured');
            }
            if (!Schema::hasColumn('products', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('is_bestseller');
            }
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_new');
            }
            if (!Schema::hasColumn('products', 'show_in_homepage')) {
                $table->boolean('show_in_homepage')->default(true)->after('is_featured');
            }
            if (!Schema::hasColumn('products', 'is_bundle_product')) {
                $table->boolean('is_bundle_product')->default(false)->after('show_in_homepage');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_bestseller', 'is_new', 'is_featured', 'show_in_homepage', 'is_bundle_product']);
        });
    }
};
