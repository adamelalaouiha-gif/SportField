<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = [
        'prenom_responsable', 'nom_responsable', 'email_responsable',
        'mot_de_passe_responsable', 'nom_club', 'description',
        'telephone_club', 'adresse', 'sports', 'horaires',
        'photos', 'statut_demande',
    ];

    protected $casts = [
        'sports'   => 'array',
        'horaires' => 'array',
    ];
}
