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
            $table->text('scent_intensity_soft_text')->nullable()->after('scent_intensity');
            $table->text('scent_intensity_significant_text')->nullable()->after('scent_intensity_soft_text');
            $table->text('scent_intensity_statement_text')->nullable()->after('scent_intensity_significant_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'scent_intensity_soft_text',
                'scent_intensity_significant_text',
                'scent_intensity_statement_text'
            ]);
        });
    }
};
