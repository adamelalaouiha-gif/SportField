@extends('layouts.admin')
@section('title', 'Profil du club')
@section('page-title', 'Profil du club')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            @if(session('success'))
                <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                @if($club->photo)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/'.$club->photo) }}" height="120" style="border-radius:12px;object-fit:cover;" alt="{{ $club->nom }}">
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du club</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $club->nom) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $club->adresse) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $club->telephone) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $club->description) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Photo du club</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
