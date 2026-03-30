@extends('layouts.app')
@section('title', 'SportsField - Réservation de terrains de sport')
@section('head')
<style>
    .hero-section { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 80px 0; }
    .search-card { background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 12px; }
    .club-card { border: none; border-radius: 12px; overflow: hidden; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .club-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateY(-4px); }
    .club-image { height: 200px; object-fit: cover; transition: transform 0.3s; width: 100%; }
    .club-card:hover .club-image { transform: scale(1.05); }
    .club-image-container { position: relative; overflow: hidden; }
    .sport-badge { display: inline-block; padding: 4px 12px; border: 1px solid #e5e7eb; border-radius: 20px; font-size: 0.75rem; margin: 2px; background: white; }
    .category-badge { cursor: pointer; transition: all 0.2s; }
    .category-badge:hover { background-color: #f3f4f6; }
    .category-badge.active { background-color: #2563eb; color: white; border-color: #2563eb; }
</style>
@endsection
@section('content')

<section class="hero-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3">Réservez Votre Terrain de Sport Idéal</h1>
            <p class="lead mb-4">Trouvez et réservez des terrains de clubs sportifs près de chez vous. Du football au tennis, nous avons tout ce qu'il vous faut.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('clubs.index') }}" method="GET">
                    <div class="search-card">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" class="form-control border-0" placeholder="Rechercher des clubs ou sports..." value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="ville" class="form-control border-0" placeholder="Localisation" value="{{ request('ville') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<main class="py-5">
    <div class="container">
        <div class="mb-5">
            <h2 class="fw-bold mb-4">Parcourir par Sport</h2>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('clubs.index') }}" class="badge category-badge {{ !request('sport') ? 'active' : 'bg-white text-dark border' }} px-3 py-2 text-decoration-none">Tous les sports</a>
                @foreach(['foot' => 'Football', 'tennis' => 'Tennis', 'basketball' => 'Basketball', 'volleyball' => 'Volleyball', 'padel' => 'Padel'] as $val => $label)
                    <a href="{{ route('clubs.index', ['sport' => $val]) }}" class="badge category-badge {{ request('sport') === $val ? 'active' : 'bg-white text-dark border' }} px-3 py-2 text-decoration-none">{{ $label }}</a>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Clubs populaires</h2>
            <a href="{{ route('clubs.index') }}" class="btn btn-outline-primary">Voir tout</a>
        </div>

        <div class="row g-4">
            @forelse($clubs as $club)
            <div class="col-md-6 col-lg-4">
                <div class="card club-card h-100">
                    <div class="club-image-container">
                        @if($club->photo)
                            <img src="{{ asset('storage/'.$club->photo) }}" class="card-img-top club-image" alt="{{ $club->nom }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1545255678-30015d3842b0?w=600" class="card-img-top club-image" alt="{{ $club->nom }}">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $club->nom }}</h5>
                        <p class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> {{ $club->adresse }}</p>
                        <div class="mb-3">
                            @foreach(is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? [] as $sport)
                                <span class="sport-badge">{{ ucfirst($sport) }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('clubs.show', $club->id) }}" class="btn btn-primary w-100 mt-auto">Voir plus</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-building fs-1 text-muted"></i>
                <p class="text-muted mt-3">Aucun club disponible pour le moment.</p>
            </div>
            @endforelse
        </div>
    </div>

    <section class="container mt-5 pt-4 mb-4">
        <div class="bg-dark text-white rounded-4 p-5 text-center position-relative overflow-hidden" style="box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(45deg, rgba(37,99,235,0.2), transparent); pointer-events: none;"></div>
            <div class="position-relative z-1">
                <h2 class="fw-bold mb-3">Vous gérez un complexe sportif ?</h2>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 600px;">Rejoignez le réseau SportsField pour augmenter votre visibilité et digitaliser vos réservations.</p>
                <a href="{{ route('visiteur.demande') }}" class="btn btn-primary btn-lg px-4 d-inline-flex align-items-center gap-2 fw-semibold">
                    <i class="bi bi-rocket-takeoff"></i> Inscrire mon club gratuitement
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
