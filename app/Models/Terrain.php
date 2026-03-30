<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Terrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'type_sport', 'prix_heure', 'photo', 'id_club',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class, 'id_club');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_terrain');
    }
}
