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
        Schema::create('theme_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color1'); // カラーコードを格納
            $table->string('color2');
            $table->string('color3');
            $table->string('theme_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_colors');
    }
};
