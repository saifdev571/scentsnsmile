<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('mobile', 15);
            $table->string('pincode', 10);
            $table->text('address');
            $table->string('locality');
            $table->string('city');
            $table->string('state');
            $table->string('landmark')->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->enum('address_type', ['home', 'work'])->default('home');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
