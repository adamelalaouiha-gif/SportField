@extends('layouts.app')
@section('title', 'Mon Profil - SportsField')
@section('head')
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 50px 0; margin-bottom: 40px; }
    .profile-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 35px; }
    .avatar-circle { width: 80px; height: 80px; background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold; }
</style>
@endsection
@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-person-circle me-2"></i>Mon Profil</h1>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="profile-card">
                <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom">
                    <div class="avatar-circle">{{ strtoupper(substr($user->prenom, 0, 1)) }}</div>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $user->prenom }} {{ $user->nom }}</h4>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        <span class="badge bg-primary mt-1">Client</span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif

                <form method="POST" action="{{ route('client.profil.update') }}">
                    @csrf @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
