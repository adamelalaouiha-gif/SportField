<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'role',
        'email_verified_at', 'verification_code', 'verification_code_expires_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'            => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'password'                     => 'hashed',
        ];
    }

    public function clubs()
    {
        return $this->hasOne(Club::class, 'id_admin');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_utilisateur');
    }
}
