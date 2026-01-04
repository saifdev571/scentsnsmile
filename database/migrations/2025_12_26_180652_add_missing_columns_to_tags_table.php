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
        Schema::table('tags', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('tags', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('tags', 'color')) {
                $table->string('color', 7)->default('#3B82F6')->after('description');
            }
            if (!Schema::hasColumn('tags', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
                $table->index(['is_featured']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            if (Schema::hasColumn('tags', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('tags', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('tags', 'is_featured')) {
                $table->dropIndex(['is_featured']);
                $table->dropColumn('is_featured');
            }
        });
    }
};
