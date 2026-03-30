@extends('layouts.admin')
@section('title', 'Réservations')
@section('page-title', 'Réservations')
@section('page-subtitle', 'Toutes les réservations de votre club')
@section('content')

<div class="table-card">
    <div class="row g-3 mb-4">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="statut" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="terminée" {{ request('statut') === 'terminée' ? 'selected' : '' }}>Terminée</option>
                <option value="annulée" {{ request('statut') === 'annulée' ? 'selected' : '' }}>Annulée</option>
                <option value="non_venue" {{ request('statut') === 'non_venue' ? 'selected' : '' }}>Non venue</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Client</th>
                    <th>Terrain</th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Montant</th>
                    <th>Paiement</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                <tr>
                    <td>
                        <div class="fw-medium">{{ $r->visiteur->prenom }} {{ $r->visiteur->nom }}</div>
                        <small class="text-muted">{{ $r->visiteur->email }}</small>
                    </td>
                    <td>{{ $r->terrain->nom }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}</td>
                    <td>{{ substr($r->heure_debut,0,5) }} - {{ substr($r->heure_fin,0,5) }}</td>
                    <td class="fw-bold">{{ number_format($r->montant,0) }} DH</td>
                    <td>
                        <span class="badge {{ $r->statut_paiements === 'paye' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $r->statut_paiements === 'paye' ? 'Payé' : 'En attente' }}
                        </span>
                    </td>
                    <td>
                        @php $badges = ['en_attente'=>'warning','terminée'=>'success','annulée'=>'danger','non_venue'=>'secondary']; @endphp
                        <span class="badge bg-{{ $badges[$r->statut_reservation] ?? 'secondary' }}">{{ ucfirst(str_replace('_',' ',$r->statut_reservation)) }}</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.reservation.statut', $r->id) }}" class="d-flex gap-1">
                            @csrf @method('PATCH')
                            <select name="statut" class="form-select form-select-sm" style="width:auto;">
                                <option value="en_attente" {{ $r->statut_reservation === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="terminée" {{ $r->statut_reservation === 'terminée' ? 'selected' : '' }}>Terminée</option>
                                <option value="non_venue" {{ $r->statut_reservation === 'non_venue' ? 'selected' : '' }}>Non venue</option>
                                <option value="annulée" {{ $r->statut_reservation === 'annulée' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="bi bi-check"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-5 text-muted">Aucune réservation trouvée</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $reservations->withQueryString()->links() }}</div>
</div>
@endsection
