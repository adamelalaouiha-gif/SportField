@extends('layouts.superadmin')
@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des utilisateurs')
@section('content')

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="q" class="form-control w-auto" placeholder="Nom ou email..." value="{{ request('q') }}">
            <select name="role" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les rôles</option>
                <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Clients</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admins clubs</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admins</option>
            </select>
            <button class="btn btn-primary">Rechercher</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Inscription</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($utilisateurs as $u)
                <tr>
                    <td class="fw-medium">{{ $u->prenom }} {{ $u->nom }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @php $roleColors = ['client'=>'primary','admin'=>'warning','super_admin'=>'danger']; @endphp
                        <span class="badge bg-{{ $roleColors[$u->role] ?? 'secondary' }}">{{ ucfirst(str_replace('_',' ',$u->role)) }}</span>
                    </td>
                    <td><small>{{ $u->created_at->format('d/m/Y') }}</small></td>
                    <td>
                        @if($u->role !== 'super_admin')
                        <form method="POST" action="{{ route('superadmin.utilisateur.delete', $u->id) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Aucun utilisateur trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $utilisateurs->withQueryString()->links() }}</div>
</div>
@endsection
