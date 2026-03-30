@extends('layouts.superadmin')
@section('title', 'Super Admin')
@section('page-title', 'Tableau de bord Super Admin')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Utilisateurs</p><h3 class="fw-bold mb-0">{{ $stats['utilisateurs'] }}</h3></div>
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Clubs actifs</p><h3 class="fw-bold mb-0">{{ $stats['clubs'] }}</h3></div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Demandes en attente</p><h3 class="fw-bold mb-0">{{ $stats['demandes'] }}</h3></div>
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-inbox"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Réservations</p><h3 class="fw-bold mb-0">{{ $stats['reservations'] }}</h3></div>
                <div class="stat-icon" style="background:#fce7f3;color:#db2777;"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-inbox me-2 text-warning"></i>Demandes en attente</h5>
        <a href="{{ route('superadmin.demandes') }}" class="btn btn-outline-primary btn-sm">Voir tout</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Club</th><th>Responsable</th><th>Sports</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($demandes_recentes as $d)
                <tr>
                    <td>
                        <div class="fw-medium">{{ $d->nom_club }}</div>
                        <small class="text-muted">{{ $d->adresse }}</small>
                    </td>
                    <td>
                        {{ $d->prenom_responsable }} {{ $d->nom_responsable }}<br>
                        <small class="text-muted">{{ $d->email_responsable }}</small>
                    </td>
                    <td>
                        @foreach(is_array($d->sports) ? $d->sports : json_decode($d->sports, true) ?? [] as $s)
                            <span class="badge bg-light text-dark border me-1">{{ $s }}</span>
                        @endforeach
                    </td>
                    <td>{{ $d->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('superadmin.demande.show', $d->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>
                            <form method="POST" action="{{ route('superadmin.demande.approuver', $d->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Approuver ce club ?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('superadmin.demande.rejeter', $d->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Rejeter cette demande ?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Aucune demande en attente</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
