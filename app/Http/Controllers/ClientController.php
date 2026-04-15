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
            'heure_debut'      => 'required|date_format:H:i',
            'heure_fin'        => 'required|date_format:H:i',
            'methode_paiement' => 'required|in:en_ligne,sur_place',
        ]);

        // Validation carte si paiement en ligne
        if ($request->methode_paiement === 'en_ligne') {
            $request->validate([
                'carte_nom'    => 'required|string|min:3',
                'carte_numero' => ['required', 'regex:/^\d{4} \d{4} \d{4} \d{4}$/'],
                'carte_expiry' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
                'carte_cvv'    => ['required', 'regex:/^\d{3}$/'],
            ], [
                'carte_nom.required'    => 'Le nom du titulaire est obligatoire.',
                'carte_nom.min'         => 'Le nom du titulaire est invalide.',
                'carte_numero.required' => 'Le numéro de carte est obligatoire.',
                'carte_numero.regex'    => 'Numéro de carte invalide (format : XXXX XXXX XXXX XXXX).',
                'carte_expiry.required' => "La date d'expiration est obligatoire.",
                'carte_expiry.regex'    => "Format de date invalide (MM/AA).",
                'carte_cvv.required'    => 'Le CVV est obligatoire.',
                'carte_cvv.regex'       => 'CVV invalide (3 chiffres).',
            ]);

            // Vérifier que la carte n'est pas expirée
            [$mm, $aa] = explode('/', $request->carte_expiry);
            $expiry = \Carbon\Carbon::createFromDate(2000 + (int)$aa, (int)$mm, 1)->endOfMonth();
            if ($expiry->isPast()) {
                return back()->withErrors(['carte_expiry' => 'Cette carte est expirée.'])->withInput();
            }
        }

        // Vérifier que heure_fin > heure_debut (00:00 = minuit = fin de journée)
        $tD = strtotime($request->heure_debut);
        $tF = $request->heure_fin === '00:00' ? strtotime('+1 day', strtotime('00:00')) : strtotime($request->heure_fin);
        if ($tF <= $tD) {
            return back()->withErrors(['heure_fin' => "L'heure de fin doit être après l'heure de début."])->withInput();
        }

        // Vérifier que le jour est ouvert et que les heures sont dans les horaires du club
        $terrain->load('club');
        $joursMap = [0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi'];
        $jourNom  = $joursMap[date('w', strtotime($request->date_reservation))];
        $horairesRaw = $terrain->club->horaires[$jourNom] ?? null;

        // Normaliser : gérer tous les formats possibles
        // Format 1 (ancien) : "11:00 - 00:00" (string)
        // Format 2 (nouveau) : ['ouverture' => '11:00', 'fermeture' => '00:00'] (array)
        if (is_string($horairesRaw) && str_contains($horairesRaw, ' - ')) {
            [$ouv, $fer] = explode(' - ', $horairesRaw);
            $horaires = ['ouverture' => trim($ouv), 'fermeture' => trim($fer)];
        } elseif (is_array($horairesRaw) && isset($horairesRaw['ouverture']) && isset($horairesRaw['fermeture'])) {
            $horaires = $horairesRaw;
        } else {
            $horaires = null;
        }

        if (empty($horaires['ouverture']) || empty($horaires['fermeture'])) {
            return back()->withErrors(['date_reservation' => "Le club est fermé le $jourNom."]);
        }

        // Utiliser strtotime pour comparer (00:00 fermeture = minuit = fin de journée)
        $tDebut  = strtotime($request->heure_debut);
        $tFin    = strtotime($request->heure_fin);
        $tOuv    = strtotime($horaires['ouverture']);
        $tFer    = ($horaires['fermeture'] === '00:00') ? strtotime('+1 day', strtotime('00:00')) : strtotime($horaires['fermeture']);

        if ($tDebut < $tOuv || $tFin > $tFer) {
            return back()->withErrors(['heure_debut' => "Les horaires doivent être entre {$horaires['ouverture']} et {$horaires['fermeture']}."]);
        }

        // Calcul du montant (00:00 heure_fin = minuit = fin de journée)
        $debut   = strtotime($request->heure_debut);
        $fin     = ($request->heure_fin === '00:00') ? strtotime('+1 day', strtotime('00:00')) : strtotime($request->heure_fin);
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
            'statut_paiements'  => $request->methode_paiement === 'en_ligne' ? 'paye' : 'en_attente',
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
