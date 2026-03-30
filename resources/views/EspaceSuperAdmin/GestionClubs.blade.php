@extends('layouts.superadmin')
@section('title', 'Gestion clubs')
@section('page-title', 'Gestion des clubs')
@section('content')

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control w-auto" placeholder="Rechercher un club..." value="{{ request('q') }}">
            <button class="btn btn-primary">Rechercher</button>
            @if(request('q'))<a href="{{ route('superadmin.clubs') }}" class="btn btn-outline-secondary">Réinitialiser</a>@endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Club</th><th>Admin</th><th>Sports</th><th>Terrains</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($clubs as $club)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($club->photo)
                                <img src="{{ asset('storage/'.$club->photo) }}" width="45" height="45" style="object-fit:cover;border-radius:8px;">
                            @else
                                <div style="width:45px;height:45px;background:#e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-building text-muted"></i></div>
                            @endif
                            <div>
                                <div class="fw-medium">{{ $club->nom }}</div>
                                <small class="text-muted">{{ $club->adresse }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($club->admin)
                            <div>{{ $club->admin->prenom }} {{ $club->admin->nom }}</div>
                            <small class="text-muted">{{ $club->admin->email }}</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @foreach(is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? [] as $s)
                            <span class="badge bg-light text-dark border me-1">{{ $s }}</span>
                        @endforeach
                    </td>
                    <td><span class="badge bg-primary">{{ $club->terrains->count() }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.club.delete', $club->id) }}" onsubmit="return confirm('Supprimer ce club et tous ses terrains ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Aucun club trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $clubs->withQueryString()->links() }}</div>
</div>
@endsection
