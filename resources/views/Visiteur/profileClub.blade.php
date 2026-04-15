@extends('layouts.app')
@section('title', $club->nom . ' - SportsField')
@section('head')
    <style>
        .club-hero { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 60px 0; }
        .club-hero-img { width: 100%; height: 300px; object-fit: cover; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .terrain-card { border: none; border-radius: 12px; overflow: hidden; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .terrain-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateY(-3px); }
        .terrain-img { height: 180px; object-fit: cover; width: 100%; }
        .sport-badge { display: inline-block; padding: 5px 14px; border: 1px solid rgba(255,255,255,0.4); border-radius: 20px; font-size: 0.8rem; margin: 3px; color: white; }
        .info-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 20px; }
    </style>
@endsection
@section('content')

    <div class="club-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('accueil') }}" class="text-white-50 text-decoration-none">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}" class="text-white-50 text-decoration-none">Clubs</a></li>
                            <li class="breadcrumb-item active text-white">{{ $club->nom }}</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold mb-3">{{ $club->nom }}</h1>
                    <p class="mb-3 opacity-75"><i class="bi bi-geo-alt me-2"></i>{{ $club->adresse }}</p>
                    @if($club->telephone)
                        <p class="mb-3 opacity-75"><i class="bi bi-telephone me-2"></i>{{ $club->telephone }}</p>
                    @endif
                    <div class="mb-3">
                        @foreach(is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? [] as $sport)
                            <span class="sport-badge">{{ ucfirst($sport) }}</span>
                        @endforeach
                    </div>
                    @if($club->description)
                        <p class="opacity-90">{{ $club->description }}</p>
                    @endif
                </div>
                <div class="col-lg-5">
                    @if($club->photo)
                        <img src="{{ asset('storage/'.$club->photo) }}" class="club-hero-img" alt="{{ $club->nom }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1545255678-30015d3842b0?w=600" class="club-hero-img" alt="{{ $club->nom }}">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-4">Terrains disponibles <span class="badge bg-primary ms-2">{{ $club->terrains->count() }}</span></h2>
                <div class="row g-4">
                    @forelse($club->terrains as $terrain)
                        <div class="col-md-6">
                            <div class="card terrain-card h-100">
                                @if($terrain->photo)
                                    <img src="{{ asset('storage/'.$terrain->photo) }}" class="terrain-img" alt="{{ $terrain->nom }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=400" class="terrain-img" alt="{{ $terrain->nom }}">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold mb-0">{{ $terrain->nom }}</h5>
                                        <span class="badge bg-primary">{{ number_format($terrain->prix_heure, 0) }} DH/h</span>
                                    </div>
                                    <p class="text-muted small mb-2"><i class="bi bi-trophy me-1"></i>{{ ucfirst($terrain->type_sport) }}</p>
                                    @if($terrain->description)
                                        <p class="text-muted small mb-3">{{ Str::limit($terrain->description, 80) }}</p>
                                    @endif
                                    @auth
                                        @if(auth()->user()->role === 'client')
                                            <a href="{{ route('client.reserver', $terrain->id) }}" class="btn btn-primary mt-auto">Réserver ce terrain</a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary mt-auto">Réserver</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary mt-auto">Se connecter pour réserver</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-geo fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Aucun terrain disponible pour ce club.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-4">
                @if($club->horaires)
                    <div class="info-card">
                        <h5 class="fw-bold mb-3"><i class="bi bi-clock me-2 text-primary"></i>Horaires d'ouverture</h5>
                        @php $horaires = is_array($club->horaires) ? $club->horaires : json_decode($club->horaires, true) ?? []; @endphp
                        @foreach($horaires as $jour => $heure)
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="fw-medium">{{ ucfirst($jour) }}</span>
                                @if(is_array($heure))
                                    @if(!empty($heure['ouverture']) && !empty($heure['fermeture']))
                                        <span class="text-muted">{{ $heure['ouverture'] }} – {{ $heure['fermeture'] }}</span>
                                    @else
                                        <span class="text-danger small">Fermé</span>
                                    @endif
                                @else
                                    <span class="text-muted">{{ $heure }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="info-card">
                    <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Informations</h5>
                    <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-2"></i>{{ $club->adresse }}</p>
                    @if($club->telephone)
                        <p class="text-muted small mb-0"><i class="bi bi-telephone me-2"></i>{{ $club->telephone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
