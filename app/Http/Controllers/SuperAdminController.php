<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Demande;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function accueil()
    {
        $stats = [
            'utilisateurs' => User::count(),
            'clubs'        => Club::count(),
            'demandes'     => Demande::where('statut_demande', 'en_attente')->count(),
            'reservations' => Reservation::count(),
        ];
        $demandes_recentes = Demande::where('statut_demande', 'en_attente')->latest()->take(5)->get();
        return view('EspaceSuperAdmin.acceuil', compact('stats', 'demandes_recentes'));
    }

    public function demandes(Request $request)
    {
        $query = Demande::query();
        if ($request->filled('statut')) {
            $query->where('statut_demande', $request->statut);
        }
        $demandes = $query->latest()->paginate(15);
        return view('EspaceSuperAdmin.demandes', compact('demandes'));
    }

    public function demandeShow($id)
    {
        $demande = Demande::findOrFail($id);
        return view('EspaceSuperAdmin.demande-detail', compact('demande'));
    }

    public function approuverDemande($id)
    {
        $demande = Demande::findOrFail($id);

        if ($demande->statut_demande === 'approuvee') {
            return back()->with('error', 'Cette demande est déjà approuvée.');
        }

        try {
            DB::beginTransaction();

            // Vérifier si l'email existe déjà
            $admin = User::where('email', $demande->email_responsable)->first();

            if ($admin) {
                // Mettre à jour le rôle existant
                $admin->role              = 'admin';
                $admin->email_verified_at = now();
                $admin->save();
            } else {
                // Créer le compte admin
                // Le mot de passe est déjà haché dans la table demandes
                $admin = new User();
                $admin->prenom            = $demande->prenom_responsable;
                $admin->nom               = $demande->nom_responsable;
                $admin->email             = $demande->email_responsable;
                $admin->password          = $demande->mot_de_passe_responsable; // déjà haché
                $admin->role              = 'admin';
                $admin->email_verified_at = now();
                $admin->save();
            }

            // Vérifier si le club n'existe pas déjà
            $clubExistant = Club::where('id_admin', $admin->id)->first();

            if (!$clubExistant) {
                $club = new Club();
                $club->nom         = $demande->nom_club;
                $club->adresse     = $demande->adresse;
                $club->telephone   = $demande->telephone_club;
                $club->description = $demande->description;
                $club->photo       = $demande->photos;
                $club->sports      = $demande->sports ?? [];
                $club->horaires    = $demande->horaires ?? [];
                $club->id_admin    = $admin->id;
                $club->save();
            }

            $demande->statut_demande = 'approuvee';
            $demande->save();

            DB::commit();
            return back()->with('success', "Club '{$demande->nom_club}' approuvé avec succès !");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur approbation demande: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'approbation : ' . $e->getMessage());
        }
    }

    public function rejeterDemande($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->update(['statut_demande' => 'rejetee']);
        return back()->with('success', 'Demande rejetée.');
    }

    public function clubs(Request $request)
    {
        $query = Club::with('admin');
        if ($request->filled('q')) {
            $query->where('nom', 'like', '%' . $request->q . '%');
        }
        $clubs = $query->latest()->paginate(15);
        return view('EspaceSuperAdmin.GestionClubs', compact('clubs'));
    }

    public function deleteClub($id)
    {
        $club = Club::findOrFail($id);
        $club->delete();
        return back()->with('success', 'Club supprimé.');
    }

    public function utilisateurs(Request $request)
    {
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }
        $utilisateurs = $query->latest()->paginate(15);
        return view('EspaceSuperAdmin.GestionUtilisateurs', compact('utilisateurs'));
    }

    public function deleteUtilisateur($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Impossible de supprimer un super admin.');
        }
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function reservations(Request $request)
    {
        $query = Reservation::with(['visiteur', 'terrain.club']);
        if ($request->filled('statut')) {
            $query->where('statut_reservation', $request->statut);
        }
        $reservations = $query->latest()->paginate(15);
        return view('EspaceSuperAdmin.reservations', compact('reservations'));
    }
}
