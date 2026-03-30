@extends('layouts.admin')
@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Bienvenue, ' . auth()->user()->prenom)
@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Total terrains</p>
                    <h3 class="fw-bold mb-0">{{ $stats['terrains'] }}</h3>
                </div>
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-geo"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Réservations totales</p>
                    <h3 class="fw-bold mb-0">{{ $stats['reservations'] }}</h3>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">En attente</p>
                    <h3 class="fw-bold mb-0">{{ $stats['en_attente'] }}</h3>
                </div>
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Revenus (DH)</p>
                    <h3 class="fw-bold mb-0">{{ number_format($stats['revenus'], 0) }}</h3>
                </div>
                <div class="stat-icon" style="background:#fce7f3;color:#db2777;"><i class="bi bi-cash-stack"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Réservations récentes</h5>
        <a href="{{ route('admin.reservations') }}" class="btn btn-outline-primary btn-sm">Voir tout</a>
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
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations_recentes as $r)
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
                        @php $badges = ['en_attente'=>'warning','terminée'=>'success','annulée'=>'danger','non_venue'=>'secondary']; @endphp
                        <span class="badge bg-{{ $badges[$r->statut_reservation] ?? 'secondary' }}">{{ ucfirst(str_replace('_',' ',$r->statut_reservation)) }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune réservation</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
