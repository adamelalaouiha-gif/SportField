@extends('layouts.admin')
@section('title', 'Mes terrains')
@section('page-title', 'Mes terrains')
@section('page-subtitle', 'Gérez les terrains de votre club')
@section('content')

<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.terrains.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Ajouter un terrain
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Sport</th>
                    <th>Prix/heure</th>
                    <th>Réservations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($terrains as $t)
                <tr>
                    <td>
                        @if($t->photo)
                            <img src="{{ asset('storage/'.$t->photo) }}" width="60" height="45" style="object-fit:cover;border-radius:6px;" alt="{{ $t->nom }}">
                        @else
                            <div style="width:60px;height:45px;background:#e5e7eb;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td><span class="fw-medium">{{ $t->nom }}</span></td>
                    <td><span class="badge bg-light text-dark border">{{ ucfirst($t->type_sport) }}</span></td>
                    <td class="fw-bold">{{ number_format($t->prix_heure, 0) }} DH</td>
                    <td><span class="badge bg-primary">{{ $t->reservations->count() }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.terrains.edit', $t->id) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.terrains.delete', $t->id) }}" onsubmit="return confirm('Supprimer ce terrain ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5">
                    <i class="bi bi-geo fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Aucun terrain ajouté</p>
                    <a href="{{ route('admin.terrains.create') }}" class="btn btn-primary btn-sm">Ajouter votre premier terrain</a>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
