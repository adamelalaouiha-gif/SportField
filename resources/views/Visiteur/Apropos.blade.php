@extends('layouts.app')
@section('title', 'À propos - SportsField')
@section('head')
<style>
    .page-header { background: linear-gradient(135deg, rgba(37,99,235,0.95), rgba(30,64,175,0.95)), url('https://images.unsplash.com/photo-1526676037777-05a232554f77?w=1920') center/cover; color: white; padding: 80px 0; margin-bottom: 60px; }
    .story-img { border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; height: 400px; object-fit: cover; }
    .value-card { background: white; border-radius: 16px; padding: 30px; height: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; transition: transform 0.3s; }
    .value-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .value-icon { width: 60px; height: 60px; background-color: rgba(37,99,235,0.1); color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 20px; }
</style>
@endsection
@section('content')

<header class="page-header text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Notre Mission</h1>
        <p class="lead text-white-50 mx-auto" style="max-width:700px;">Rendre le sport accessible à tous en simplifiant la connexion entre les sportifs et les meilleures infrastructures locales.</p>
    </div>
</header>

<main>
    <section class="container mb-5 pb-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-primary fw-bold text-uppercase small mb-2 d-block">L'origine du projet</span>
                <h2 class="fw-bold mb-4">Plus qu'une plateforme, une véritable passion pour le jeu.</h2>
                <p class="text-muted mb-4">Tout a commencé face à un constat simple : organiser un match entre amis était souvent un parcours du combattant. Il fallait appeler plusieurs clubs, vérifier les disponibilités un par un, et gérer les annulations de dernière minute.</p>
                <p class="text-muted mb-0">En alliant notre passion pour le sport et notre expertise en ingénierie logicielle, nous avons créé <strong>SportsField</strong> — la solution pour digitaliser la réservation d'infrastructures sportives.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800" alt="Équipe" class="story-img">
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Nos Valeurs</h2>
            <p class="text-muted">Ce qui nous motive au quotidien.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h4 class="fw-bold mb-3">Simplicité</h4>
                    <p class="text-muted mb-0">Des interfaces épurées pour que trouver et réserver un terrain se fasse en moins d'une minute.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-people-fill"></i></div>
                    <h4 class="fw-bold mb-3">Communauté</h4>
                    <p class="text-muted mb-0">Le sport rassemble. Nous facilitons les rencontres et encourageons la pratique sportive.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-shield-check"></i></div>
                    <h4 class="fw-bold mb-3">Fiabilité</h4>
                    <p class="text-muted mb-0">Des disponibilités en temps réel et des paiements sécurisés pour une tranquillité d'esprit totale.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="bg-primary text-white rounded-4 p-5 text-center">
            <h2 class="fw-bold mb-3">Prêt pour votre prochain match ?</h2>
            <p class="lead text-white-50 mb-4 mx-auto" style="max-width:600px;">Trouvez le terrain idéal près de chez vous et réservez-le en quelques clics.</p>
            <a href="{{ route('clubs.index') }}" class="btn btn-light btn-lg text-primary fw-bold px-4">Trouver un terrain</a>
        </div>
    </section>
</main>
@endsection
