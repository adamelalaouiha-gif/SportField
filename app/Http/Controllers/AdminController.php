<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Reservation;
use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function getClub()
    {
        return Club::where('id_admin', Auth::id())->firstOrFail();
    }

    public function accueil()
    {
        $club = $this->getClub();
        $terrainIds = $club->terrains->pluck('id');

        $stats = [
            'terrains'    => $club->terrains->count(),
            'reservations'=> Reservation::whereIn('id_terrain', $terrainIds)->count(),
            'en_attente'  => Reservation::whereIn('id_terrain', $terrainIds)->where('statut_reservation', 'en_attente')->count(),
            'revenus'     => Reservation::whereIn('id_terrain', $terrainIds)->where('statut_reservation', 'terminée')->sum('montant'),
        ];

        $reservations_recentes = Reservation::with(['visiteur', 'terrain'])
            ->whereIn('id_terrain', $terrainIds)
            ->latest()->take(8)->get();

        return view('EspaceAdmin.acceuil', compact('stats', 'reservations_recentes'));
    }

    public function terrains()
    {
        $club    = $this->getClub();
        $terrains = Terrain::with('reservations')->where('id_club', $club->id)->get();
        return view('EspaceAdmin.MesTerrains', compact('terrains'));
    }

    public function terrainCreate()
    {
        return view('EspaceAdmin.ajouterTerrain');
    }

    public function terrainStore(Request $request)
    {
        $club = $this->getClub();
        $request->validate([
            'nom'        => 'required|string|max:255',
            'type_sport' => 'required|in:foot,basketball,tennis,padel,volleyball',
            'prix_heure' => 'required|numeric|min:0',
            'description'=> 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'description', 'type_sport', 'prix_heure');
        $data['id_club'] = $club->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('terrains', 'public');
        }

        Terrain::create($data);
        return redirect()->route('admin.terrains')->with('success', 'Terrain ajouté avec succès.');
    }

    public function terrainEdit($id)
    {
        $club    = $this->getClub();
        $terrain = Terrain::where('id_club', $club->id)->findOrFail($id);
        return view('EspaceAdmin.ajouterTerrain', compact('terrain'));
    }

    public function terrainUpdate(Request $request, $id)
    {
        $club    = $this->getClub();
        $terrain = Terrain::where('id_club', $club->id)->findOrFail($id);

        $request->validate([
            'nom'        => 'required|string|max:255',
            'type_sport' => 'required|in:foot,basketball,tennis,padel,volleyball',
            'prix_heure' => 'required|numeric|min:0',
            'description'=> 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'description', 'type_sport', 'prix_heure');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('terrains', 'public');
        }

        $terrain->update($data);
        return redirect()->route('admin.terrains')->with('success', 'Terrain mis à jour.');
    }

    public function terrainDelete($id)
    {
        $club    = $this->getClub();
        $terrain = Terrain::where('id_club', $club->id)->findOrFail($id);
        $terrain->delete();
        return back()->with('success', 'Terrain supprimé.');
    }

    public function reservations(Request $request)
    {
        $club       = $this->getClub();
        $terrainIds = $club->terrains->pluck('id');
        $query      = Reservation::with(['visiteur', 'terrain'])->whereIn('id_terrain', $terrainIds);

        if ($request->filled('statut')) {
            $query->where('statut_reservation', $request->statut);
        }

        $reservations = $query->latest()->paginate(15);
        return view('EspaceAdmin.Reservations', compact('reservations'));
    }

    public function updateStatutReservation(Request $request, $id)
    {
        $club       = $this->getClub();
        $terrainIds = $club->terrains->pluck('id');
        $reservation = Reservation::whereIn('id_terrain', $terrainIds)->findOrFail($id);

        $request->validate(['statut' => 'required|in:en_attente,terminée,non_venue,annulée']);
        $reservation->update(['statut_reservation' => $request->statut]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function profil()
    {
        $club = $this->getClub();
        return view('EspaceAdmin.PrifileClub', compact('club'));
    }

    public function profilUpdate(Request $request)
    {
        $club = $this->getClub();
        $request->validate([
            'nom'        => 'required|string|max:255',
            'adresse'    => 'required|string|max:255',
            'telephone'  => 'nullable|string|max:20',
            'description'=> 'nullable|string',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'adresse', 'telephone', 'description');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('clubs', 'public');
        }

        $club->update($data);
        return back()->with('success', 'Profil du club mis à jour.');
    }
}
