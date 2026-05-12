<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ["name", "login", "phone", "email", "password"];

    protected $hidden = ["password", "remember_token"];

    protected function casts(): array
    {
        return [
            "password" => "hashed",
        ];
    }

    public function isAdmin(): bool
    {
        return $this->login === "adminka";
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
