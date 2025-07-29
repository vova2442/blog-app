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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            // ID того, кто подписывается (follower)
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            // ID того, на кого подписываются (the user being followed)
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Уникальный ключ, чтобы нельзя было подписаться на одного и того же пользователя дважды
            $table->unique(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};



