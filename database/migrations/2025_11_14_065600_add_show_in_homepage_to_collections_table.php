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
        if (Schema::hasTable('collections')) {
            Schema::table('collections', function (Blueprint $table) {
                if (!Schema::hasColumn('collections', 'show_in_homepage')) {
                    $table->boolean('show_in_homepage')->default(false)->after('is_active');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('show_in_homepage');
        });
    }
};
