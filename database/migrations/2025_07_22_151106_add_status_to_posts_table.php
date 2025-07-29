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
        Schema::table('posts', function (Blueprint $table) {
            // Добавляем колонку status после колонки 'body'
            // По умолчанию все посты будут публичными
            $table->string('status')->default('public')->after('body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Этот метод нужен для отката миграции, он удалит нашу колонку
            $table->dropColumn('status');
        });
    }
};




