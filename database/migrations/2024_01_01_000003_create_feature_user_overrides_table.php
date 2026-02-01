<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_user_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_flag_id')->constrained('feature_flags')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_enabled');
            $table->timestamps();

            $table->unique(['feature_flag_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_user_overrides');
    }
};