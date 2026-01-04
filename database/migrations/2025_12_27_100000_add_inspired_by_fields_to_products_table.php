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
            $table->string('inspired_by')->nullable()->after('name');
            $table->decimal('retail_price', 10, 2)->nullable()->after('inspired_by');
            $table->string('retail_price_color', 20)->nullable()->default('#B8860B')->after('retail_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['inspired_by', 'retail_price', 'retail_price_color']);
        });
    }
};
