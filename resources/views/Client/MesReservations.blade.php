@extends('layouts.app')
@section('title', 'Mes réservations - SportsField')
@section('head')
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 50px 0; margin-bottom: 40px; }
    .reservation-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 16px; border-left: 4px solid #e5e7eb; transition: all 0.2s; }
    .reservation-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
    .reservation-card.en_attente { border-left-color: #f59e0b; }
    .reservation-card.terminée { border-left-color: #10b981; }
    .reservation-card.annulée { border-left-color: #ef4444; }
    .reservation-card.non_venue { border-left-color: #6b7280; }
</style>
@endsection
@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-calendar-check me-2"></i>Mes réservations</h1>
        <p class="opacity-75 mb-0">Gérez toutes vos réservations de terrains</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <select name="statut" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="terminée" {{ request('statut') === 'terminée' ? 'selected' : '' }}>Terminée</option>
                <option value="annulée" {{ request('statut') === 'annulée' ? 'selected' : '' }}>Annulée</option>
                <option value="non_venue" {{ request('statut') === 'non_venue' ? 'selected' : '' }}>Non venue</option>
            </select>
        </form>
    </div>

    @forelse($reservations as $r)
    <div class="reservation-card {{ $r->statut_reservation }}">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="fw-bold mb-1">{{ $r->terrain->nom }}</h5>
                <p class="text-muted small mb-1"><i class="bi bi-building me-1"></i>{{ $r->terrain->club->nom }}</p>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}
                    &nbsp;|&nbsp;
                    <i class="bi bi-clock me-1"></i>{{ substr($r->heure_debut, 0, 5) }} - {{ substr($r->heure_fin, 0, 5) }}
                </p>
            </div>
            <div class="col-md-3 text-md-center mt-3 mt-md-0">
                <div class="fw-bold fs-5">{{ number_format($r->montant, 0) }} DH</div>
                <small class="text-muted">{{ $r->methode_paiement === 'sur_place' ? 'Sur place' : 'En ligne' }}</small>
            </div>
            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                @php
                    $badges = ['en_attente' => 'warning', 'terminée' => 'success', 'annulée' => 'danger', 'non_venue' => 'secondary'];
                    $labels = ['en_attente' => 'En attente', 'terminée' => 'Terminée', 'annulée' => 'Annulée', 'non_venue' => 'Non venue'];
                @endphp
                <span class="badge bg-{{ $badges[$r->statut_reservation] ?? 'secondary' }} mb-2">{{ $labels[$r->statut_reservation] ?? $r->statut_reservation }}</span>
                @if($r->statut_reservation === 'en_attente')
                <form method="POST" action="{{ route('client.reservation.annuler', $r->id) }}" class="d-block">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Annuler cette réservation ?')">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="bi bi-calendar-x fs-1 text-muted"></i>
        <h5 class="mt-3 text-muted">Aucune réservation trouvée</h5>
        <a href="{{ route('clubs.index') }}" class="btn btn-primary mt-3">Réserver un terrain</a>
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $reservations->withQueryString()->links() }}
    </div>
</div>
@endsection
