<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Shipping dimensions for Shiprocket
            $table->decimal('weight', 10, 2)->default(0.5)->after('stock')->comment('Weight in KG');
            $table->decimal('length', 10, 2)->default(10)->after('weight')->comment('Length in CM');
            $table->decimal('breadth', 10, 2)->default(10)->after('length')->comment('Breadth in CM');
            $table->decimal('height', 10, 2)->default(10)->after('breadth')->comment('Height in CM');
            $table->string('hsn_code', 20)->nullable()->after('height')->comment('HSN Code for GST');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'length', 'breadth', 'height', 'hsn_code']);
        });
    }
};
