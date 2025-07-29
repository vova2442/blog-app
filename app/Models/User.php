<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Посты, которые написал этот пользователь.
     * Это связь "один ко многим": один пользователь может иметь много постов.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Пользователи, на которых подписан ЭТОТ пользователь.
     * Это связь "многие ко многим".
     */
    public function following(): BelongsToMany
    {
        // 1-й арг: Модель, с которой связь
        // 2-й арг: Сводная таблица
        // 3-й арг: Внешний ключ в сводной таблице для ТЕКУЩЕЙ модели (User -> follower_id)
        // 4-й арг: Внешний ключ в сводной таблице для СВЯЗАННОЙ модели (тоже User -> followed_id)
        return $this->belongsToMany(User::class, 'subscriptions', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * Пользователи, которые подписаны на ЭТОГО пользователя (его подписчики).
     * Это та же связь "многие ко многим", но с обратными ключами.
     */
    public function followers(): BelongsToMany
    {
        // Ключи здесь поменялись местами, т.к. мы ищем, где ID текущего пользователя
        // находится в колонке 'followed_id'.
        return $this->belongsToMany(User::class, 'subscriptions', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}