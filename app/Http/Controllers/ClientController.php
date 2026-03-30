<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function accueil()
    {
        return redirect()->route('accueil');
    }

    public function reservations(Request $request)
    {
        $query = Reservation::with(['terrain.club'])
            ->where('id_utilisateur', Auth::id());

        if ($request->filled('statut')) {
            $query->where('statut_reservation', $request->statut);
        }

        $reservations = $query->latest()->paginate(10);
        return view('Client.MesReservations', compact('reservations'));
    }

    public function reserverForm($terrainId)
    {
        $terrain = Terrain::with('club')->findOrFail($terrainId);
        return view('Client.reserver', compact('terrain'));
    }

    public function reserverPost(Request $request, $terrainId)
    {
        $terrain = Terrain::findOrFail($terrainId);

        $request->validate([
            'date_reservation' => 'required|date|after:today',
            'heure_debut'      => 'required',
            'heure_fin'        => 'required|after:heure_debut',
            'methode_paiement' => 'required|in:en_ligne,sur_place',
        ]);

        // Calcul du montant
        $debut   = strtotime($request->heure_debut);
        $fin     = strtotime($request->heure_fin);
        $heures  = ($fin - $debut) / 3600;
        $montant = $heures * $terrain->prix_heure;

        // Vérifier conflit
        $conflit = Reservation::where('id_terrain', $terrain->id)
            ->where('date_reservation', $request->date_reservation)
            ->where('statut_reservation', '!=', 'annulée')
            ->where(function ($q) use ($request) {
                $q->whereBetween('heure_debut', [$request->heure_debut, $request->heure_fin])
                  ->orWhereBetween('heure_fin', [$request->heure_debut, $request->heure_fin]);
            })->exists();

        if ($conflit) {
            return back()->withErrors(['heure_debut' => 'Ce créneau est déjà réservé. Choisissez un autre horaire.']);
        }

        Reservation::create([
            'date_reservation'  => $request->date_reservation,
            'heure_debut'       => $request->heure_debut,
            'heure_fin'         => $request->heure_fin,
            'montant'           => $montant,
            'statut_reservation'=> 'en_attente',
            'methode_paiement'  => $request->methode_paiement,
            'statut_paiements'  => 'en_attente',
            'id_utilisateur'    => Auth::id(),
            'id_terrain'        => $terrain->id,
        ]);

        return redirect()->route('client.reservations')
            ->with('success', 'Réservation effectuée avec succès !');
    }

    public function annulerReservation($id)
    {
        $reservation = Reservation::where('id_utilisateur', Auth::id())->findOrFail($id);
        $reservation->update(['statut_reservation' => 'annulée']);
        return back()->with('success', 'Réservation annulée.');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('Client.MonProfile', compact('user'));
    }

    public function profilUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom'    => 'required|string|max:255',
            'email'  => 'required|email|unique:utilisateurs,email,' . $user->id,
        ]);
        $user->update($request->only('prenom', 'nom', 'email'));
        return back()->with('success', 'Profil mis à jour.');
    }
}
