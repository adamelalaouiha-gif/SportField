@extends('layouts.app')
@section('title', 'Clubs - SportsField')
@section('head')
<style>
    .club-card { border: none; border-radius: 12px; overflow: hidden; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .club-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateY(-4px); }
    .club-image { height: 200px; object-fit: cover; width: 100%; transition: transform 0.3s; }
    .club-card:hover .club-image { transform: scale(1.05); }
    .club-image-container { overflow: hidden; }
    .sport-badge { display: inline-block; padding: 4px 12px; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; margin: 2px; background: white; }
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 60px 0; margin-bottom: 40px; }
    .filter-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px; }
</style>
@endsection
@section('content')

<div class="page-header text-center">
    <div class="container">
        <h1 class="fw-bold mb-2">Parcourir les clubs</h1>
        <p class="lead opacity-75 mb-0">Trouvez le club idéal et réservez votre terrain</p>
    </div>
</div>

<div class="container">
    <div class="filter-card">
        <form action="{{ route('clubs.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Nom du club..." value="{{ request('q') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Sport</label>
                    <select name="sport" class="form-select">
                        <option value="">Tous les sports</option>
                        @foreach(['foot' => 'Football', 'tennis' => 'Tennis', 'basketball' => 'Basketball', 'volleyball' => 'Volleyball', 'padel' => 'Padel'] as $val => $label)
                            <option value="{{ $val }}" {{ request('sport') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Ville</label>
                    <input type="text" name="ville" class="form-control" placeholder="Ville..." value="{{ request('ville') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>
    </div>

    <p class="text-muted mb-4">{{ $clubs->total() }} club(s) trouvé(s)</p>

    <div class="row g-4">
        @forelse($clubs as $club)
        <div class="col-md-6 col-lg-4">
            <div class="card club-card h-100">
                <div class="club-image-container">
                    @if($club->photo)
                        <img src="{{ asset('storage/'.$club->photo) }}" class="club-image" alt="{{ $club->nom }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1545255678-30015d3842b0?w=600" class="club-image" alt="{{ $club->nom }}">
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $club->nom }}</h5>
                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt"></i> {{ $club->adresse }}</p>
                    @if($club->telephone)
                        <p class="text-muted small mb-3"><i class="bi bi-telephone"></i> {{ $club->telephone }}</p>
                    @endif
                    <div class="mb-3">
                        @foreach(is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? [] as $sport)
                            <span class="sport-badge">{{ ucfirst($sport) }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('clubs.show', $club->id) }}" class="btn btn-primary w-100 mt-auto">Voir les terrains</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-building fs-1 text-muted"></i>
            <h5 class="mt-3 text-muted">Aucun club trouvé</h5>
            <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
            <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">Voir tous les clubs</a>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $clubs->withQueryString()->links() }}
    </div>
</div>
@endsection
