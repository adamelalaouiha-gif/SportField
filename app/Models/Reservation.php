<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_reservation', 'heure_debut', 'heure_fin', 'montant',
        'statut_reservation', 'methode_paiement', 'statut_paiements',
        'id_utilisateur', 'id_terrain',
    ];

    public function visiteur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function terrain()
    {
        return $this->belongsTo(Terrain::class, 'id_terrain');
    }
}
