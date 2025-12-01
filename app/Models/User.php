<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // <--- 1. QUESTA MANCAVA

class User extends Authenticatable
{
    // <--- 2. AGGIUNTO 'Notifiable' QUI SOTTO
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relazione con le prenotazioni
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
