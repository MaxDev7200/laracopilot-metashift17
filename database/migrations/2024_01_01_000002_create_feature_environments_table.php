<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_environments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_flag_id')->constrained()->onDelete('cascade');
            $table->string('environment');
            $table->boolean('enabled');
            $table->timestamps();

            $table->unique(['feature_flag_id', 'environment']);
            $table->index(['environment', 'enabled']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_environments');
    }
};