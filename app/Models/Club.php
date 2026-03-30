<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'adresse', 'telephone', 'description',
        'photo', 'id_admin', 'horaires', 'sports',
    ];

    protected $casts = [
        'sports'   => 'array',
        'horaires' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function terrains()
    {
        return $this->hasMany(Terrain::class, 'id_club');
    }
}
