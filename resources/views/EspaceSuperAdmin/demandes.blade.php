@extends('layouts.superadmin')
@section('title', 'Demandes clubs')
@section('page-title', "Demandes d'inscription clubs")
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <select name="statut" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="approuvee" {{ request('statut') === 'approuvee' ? 'selected' : '' }}>Approuvées</option>
                <option value="rejetee" {{ request('statut') === 'rejetee' ? 'selected' : '' }}>Rejetées</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Club</th>
                    <th>Responsable</th>
                    <th>Contact</th>
                    <th>Sports</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $d)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($d->photos)
                                <img src="{{ asset('storage/'.$d->photos) }}" width="40" height="40"
                                     style="object-fit:cover;border-radius:8px;" alt="{{ $d->nom_club }}">
                            @else
                                <div style="width:40px;height:40px;background:#e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-building text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-medium">{{ $d->nom_club }}</div>
                                <small class="text-muted">{{ Str::limit($d->adresse, 30) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $d->prenom_responsable }} {{ $d->nom_responsable }}</td>
                    <td>
                        <small>{{ $d->email_responsable }}</small><br>
                        <small class="text-muted">{{ $d->telephone_club }}</small>
                    </td>
                    <td>
                        @php $sportsLabels = ['foot'=>'Football','basketball'=>'Basketball','tennis'=>'Tennis','padel'=>'Padel','volleyball'=>'Volleyball']; @endphp
                        @foreach(is_array($d->sports) ? $d->sports : json_decode($d->sports, true) ?? [] as $s)
                            <span class="badge bg-light text-dark border me-1">{{ $sportsLabels[$s] ?? ucfirst($s) }}</span>
                        @endforeach
                    </td>
                    <td><small>{{ $d->created_at->format('d/m/Y') }}</small></td>
                    <td>
                        @php $colors = ['en_attente'=>'warning','approuvee'=>'success','rejetee'=>'danger']; @endphp
                        <span class="badge bg-{{ $colors[$d->statut_demande] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_',' ',$d->statut_demande)) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            {{-- Bouton Voir plus --}}
                            <a href="{{ route('superadmin.demande.show', $d->id) }}"
                               class="btn btn-primary btn-sm" title="Voir les détails">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>

                            @if($d->statut_demande === 'en_attente')
                            {{-- Bouton Approuver --}}
                            <form method="POST" action="{{ route('superadmin.demande.approuver', $d->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" title="Approuver"
                                        onclick="return confirm('Approuver le club {{ $d->nom_club }} ?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            {{-- Bouton Rejeter --}}
                            <form method="POST" action="{{ route('superadmin.demande.rejeter', $d->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm" title="Rejeter"
                                        onclick="return confirm('Rejeter cette demande ?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                            @else
                                <span class="text-muted small">Traitée</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Aucune demande trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $demandes->withQueryString()->links() }}</div>
</div>
@endsection
