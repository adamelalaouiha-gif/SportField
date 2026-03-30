@extends('layouts.app')
@section('title', 'Réserver - ' . $terrain->nom)
@section('head')
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 50px 0; margin-bottom: 40px; }
    .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 35px; }
    .terrain-info-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; }
    .terrain-info-card img { width: 100%; height: 200px; object-fit: cover; }
    .price-highlight { font-size: 2rem; font-weight: bold; color: #2563eb; }
</style>
@endsection
@section('content')
<div class="page-header text-center">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}" class="text-white-50 text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clubs.show', $terrain->club->id) }}" class="text-white-50 text-decoration-none">{{ $terrain->club->nom }}</a></li>
                <li class="breadcrumb-item active text-white">Réserver</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-2">Réserver {{ $terrain->nom }}</h1>
        <p class="opacity-75">{{ $terrain->club->nom }} — {{ ucfirst($terrain->type_sport) }}</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="terrain-info-card">
                @if($terrain->photo)
                    <img src="{{ asset('storage/'.$terrain->photo) }}" alt="{{ $terrain->nom }}">
                @else
                    <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=400" alt="{{ $terrain->nom }}">
                @endif
                <div class="p-4">
                    <h5 class="fw-bold">{{ $terrain->nom }}</h5>
                    <p class="text-muted small mb-2"><i class="bi bi-trophy me-1"></i>{{ ucfirst($terrain->type_sport) }}</p>
                    <p class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $terrain->club->adresse }}</p>
                    <div class="text-center py-3 border-top">
                        <div class="price-highlight">{{ number_format($terrain->prix_heure, 0) }} DH</div>
                        <small class="text-muted">par heure</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="form-card">
                <h4 class="fw-bold mb-4">Détails de la réservation</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.reserver.post', $terrain->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date de réservation <span class="text-danger">*</span></label>
                        <input type="date" name="date_reservation" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('date_reservation') }}" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Heure de début <span class="text-danger">*</span></label>
                            <input type="time" name="heure_debut" class="form-control" value="{{ old('heure_debut') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Heure de fin <span class="text-danger">*</span></label>
                            <input type="time" name="heure_fin" class="form-control" value="{{ old('heure_fin') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Méthode de paiement <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="methode_paiement" value="sur_place" id="sur_place" {{ old('methode_paiement', 'sur_place') === 'sur_place' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sur_place"><i class="bi bi-cash me-1"></i>Sur place</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="methode_paiement" value="en_ligne" id="en_ligne" {{ old('methode_paiement') === 'en_ligne' ? 'checked' : '' }}>
                                <label class="form-check-label" for="en_ligne"><i class="bi bi-credit-card me-1"></i>En ligne</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center gap-2" id="montantInfo">
                        <i class="bi bi-calculator"></i>
                        <span>Le montant sera calculé automatiquement selon vos horaires. Prix : <strong>{{ $terrain->prix_heure }} DH/h</strong></span>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
