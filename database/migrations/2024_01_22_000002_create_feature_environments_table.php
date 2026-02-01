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
        Schema::create('feature_environments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_flag_id')->constrained()->onDelete('cascade');
            $table->string('environment'); // local, development, staging, production
            $table->boolean('is_enabled')->default(false);
            $table->integer('rollout_percentage')->default(100); // 0-100
            $table->timestamps();

            $table->unique(['feature_flag_id', 'environment']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_environments');
    }
};