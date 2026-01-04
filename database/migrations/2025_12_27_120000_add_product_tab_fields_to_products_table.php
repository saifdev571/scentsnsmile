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
        Schema::table('products', function (Blueprint $table) {
            // Product Tab Fields
            $table->text('about_scent')->nullable()->after('description');
            $table->text('fragrance_notes')->nullable()->after('about_scent');
            $table->text('why_love_it')->nullable()->after('fragrance_notes');
            $table->text('what_makes_clean')->nullable()->after('why_love_it');
            $table->text('ingredients_details')->nullable()->after('what_makes_clean');
            $table->text('shipping_info')->nullable()->after('ingredients_details');
            $table->text('disclaimer')->nullable()->after('shipping_info');
            $table->text('ask_question')->nullable()->after('disclaimer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'about_scent',
                'fragrance_notes',
                'why_love_it',
                'what_makes_clean',
                'ingredients_details',
                'shipping_info',
                'disclaimer',
                'ask_question'
            ]);
        });
    }
};
