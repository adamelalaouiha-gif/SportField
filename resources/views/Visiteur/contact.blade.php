@extends('layouts.app')
@section('title', 'Contact - SportsField')
@section('head')
    <style>
        .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 80px 0; margin-bottom: 60px; }
        .contact-info-card { background: white; border-radius: 16px; padding: 50px 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; text-align: center; }
        .contact-info-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.2); }
        .contact-icon { width: 80px; height: 80px; background-color: rgba(37,99,235,0.1); color: #2563eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 25px auto; }
        .contact-link { font-size: 1.3rem; transition: color 0.2s; }
        .contact-link:hover { color: #1e40af !important; }
    </style>
@endsection
@section('content')
    <header class="page-header text-center">
        <div class="container pb-4">
            <h1 class="display-4 fw-bold mb-3">Nous sommes à votre écoute</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                Une question sur une réservation ou un problème technique ? N'hésitez pas à nous contacter.
            </p>
        </div>
    </header>

    <main class="container mb-5 pb-5">
        <div class="row g-5 justify-content-center">

            <div class="col-md-6 col-lg-5">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-at"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Email</h3>
                    <p class="text-muted mb-4">Écrivez-nous à tout moment, nous vous répondrons dans les plus brefs délais.</p>
                    <a href="mailto:contact@sportsfield.ma" class="text-primary text-decoration-none fw-bold contact-link">
                        contact@sportsfield.ma
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-5">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Téléphone</h3>
                    <p class="text-muted mb-4">Notre équipe est disponible du lundi au samedi, de 09h00 à 19h00.</p>
                    <a href="tel:+212600000000" class="text-primary text-decoration-none fw-bold contact-link">
                        +212 6 00 00 00 00
                    </a>
                </div>
            </div>

        </div>
    </main>
@endsection
