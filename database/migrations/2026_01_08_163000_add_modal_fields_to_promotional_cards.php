<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('promotional_cards', function (Blueprint $table) {
            $table->enum('action_type', ['link', 'modal'])->default('link')->after('media_url');

            // Modal Specific Fields
            $table->string('modal_title')->nullable()->after('button_link');
            $table->text('modal_description')->nullable()->after('modal_title');
            $table->string('modal_image_url')->nullable()->after('modal_description');
            $table->string('modal_button_text')->nullable()->after('modal_image_url');
            $table->string('modal_button_link')->nullable()->after('modal_button_text');
        });
    }

    public function down(): void
    {
        Schema::table('promotional_cards', function (Blueprint $table) {
            $table->dropColumn([
                'action_type',
                'modal_title',
                'modal_description',
                'modal_image_url',
                'modal_button_text',
                'modal_button_link'
            ]);
        });
    }
};
