<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feature_user_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_flag_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('enabled')->default(false);
            $table->timestamps();
            
            $table->unique(['feature_flag_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('feature_user_overrides');
    }
};