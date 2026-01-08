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
            $table->unsignedBigInteger('moment_id')->nullable()->after('category_id');
            $table->foreign('moment_id')->references('id')->on('moments')->onDelete('set null');
            $table->index('moment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['moment_id']);
            $table->dropIndex(['moment_id']);
            $table->dropColumn('moment_id');
        });
    }
};
