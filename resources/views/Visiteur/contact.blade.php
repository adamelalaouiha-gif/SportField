@extends('layouts.app')
@section('title', 'Contact - SportsField')
@section('head')
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 60px 0; margin-bottom: 50px; }
    .contact-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 35px; }
    .info-item { display: flex; align-items: center; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f3f4f6; }
    .info-icon { width: 48px; height: 48px; background: rgba(37,99,235,0.1); color: #2563eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
</style>
@endsection
@section('content')
<div class="page-header text-center">
    <div class="container">
        <h1 class="fw-bold mb-2">Contactez-nous</h1>
        <p class="opacity-75 mb-0">Nous sommes là pour vous aider</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-5">
        <div class="col-lg-5">
            <h3 class="fw-bold mb-4">Nos coordonnées</h3>
            <div class="info-item">
                <div class="info-icon"><i class="bi bi-envelope"></i></div>
                <div><div class="fw-semibold">Email</div><div class="text-muted">contact@sportsfield.ma</div></div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="bi bi-telephone"></i></div>
                <div><div class="fw-semibold">Téléphone</div><div class="text-muted">+212 5XX-XXXXXX</div></div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                <div><div class="fw-semibold">Adresse</div><div class="text-muted">Maroc</div></div>
            </div>
            <div class="info-item border-0">
                <div class="info-icon"><i class="bi bi-clock"></i></div>
                <div><div class="fw-semibold">Horaires</div><div class="text-muted">Lun–Ven : 9h–18h</div></div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-card">
                <h4 class="fw-bold mb-4">Envoyez-nous un message</h4>
                @if(session('success'))
                    <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
                @endif
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Prénom</label>
                            <input type="text" class="form-control" placeholder="Jean">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom</label>
                            <input type="text" class="form-control" placeholder="Dupont">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" placeholder="votre@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sujet</label>
                        <input type="text" class="form-control" placeholder="Objet de votre message">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea class="form-control" rows="5" placeholder="Votre message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i>Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
