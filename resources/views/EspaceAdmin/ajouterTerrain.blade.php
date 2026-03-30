@extends('layouts.admin')
@section('title', isset($terrain) ? 'Modifier terrain' : 'Ajouter terrain')
@section('page-title', isset($terrain) ? 'Modifier le terrain' : 'Ajouter un terrain')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ isset($terrain) ? route('admin.terrains.update', $terrain->id) : route('admin.terrains.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($terrain)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du terrain <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $terrain->nom ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $terrain->description ?? '') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-semibold">Type de sport <span class="text-danger">*</span></label>
                        <select name="type_sport" class="form-select" required>
                            @foreach(['foot' => 'Football', 'basketball' => 'Basketball', 'tennis' => 'Tennis', 'padel' => 'Padel', 'volleyball' => 'Volleyball'] as $val => $label)
                                <option value="{{ $val }}" {{ old('type_sport', $terrain->type_sport ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prix par heure (DH) <span class="text-danger">*</span></label>
                        <input type="number" name="prix_heure" class="form-control" min="0" step="0.01" value="{{ old('prix_heure', $terrain->prix_heure ?? '') }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Photo</label>
                    @if(isset($terrain) && $terrain->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$terrain->photo) }}" height="80" style="border-radius:8px;" alt="Photo actuelle">
                            <small class="text-muted ms-2">Photo actuelle</small>
                        </div>
                    @endif
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-2"></i>{{ isset($terrain) ? 'Mettre à jour' : 'Ajouter le terrain' }}
                    </button>
                    <a href="{{ route('admin.terrains') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
