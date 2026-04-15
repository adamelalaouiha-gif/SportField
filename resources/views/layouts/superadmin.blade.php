<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin') - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #0ea5e9; --sidebar-bg: #1e293b; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; }
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar-bg); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .logo-box { width: 38px; height: 38px; background: linear-gradient(135deg, #7c3aed, #4f46e5); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
        .sidebar-nav { padding: 16px 0; }
        .nav-link-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #a5b4fc; text-decoration: none; transition: all 0.2s; border-radius: 8px; margin: 2px 12px; font-size: 0.9rem; }
        .nav-link-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-link-item.active { background: #4f46e5; color: white; }
        .nav-link-item i { font-size: 1.1rem; width: 20px; }
        .nav-section-title { padding: 16px 20px 8px; font-size: 0.7rem; text-transform: uppercase; color: #6366f1; letter-spacing: 1px; font-weight: 600; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: white; padding: 16px 30px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 99; }
        .page-content { padding: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .table-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
    </style>
    @yield('head')
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo d-flex align-items-center gap-2">
        <div class="logo-box">SA</div>
        <div>
            <span class="fw-bold text-white">SportsField</span>
            <div style="font-size:0.7rem;color:#a5b4fc;">Super Administrateur</div>
        </div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section-title">Administration</div>
        <a href="{{ route('superadmin.accueil') }}" class="nav-link-item {{ request()->routeIs('superadmin.accueil') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a href="{{ route('superadmin.demandes') }}" class="nav-link-item {{ request()->routeIs('superadmin.demandes') ? 'active' : '' }}">
            <i class="bi bi-inbox"></i> Demandes clubs
            @if(isset($nb_demandes) && $nb_demandes > 0)
                <span class="badge bg-danger ms-auto">{{ $nb_demandes }}</span>
            @endif
        </a>
        <a href="{{ route('superadmin.clubs') }}" class="nav-link-item {{ request()->routeIs('superadmin.clubs') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Gestion clubs
        </a>
        <a href="{{ route('superadmin.utilisateurs') }}" class="nav-link-item {{ request()->routeIs('superadmin.utilisateurs') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Utilisateurs
        </a>
        <a href="{{ route('superadmin.reservations') }}" class="nav-link-item {{ request()->routeIs('superadmin.reservations') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Réservations
        </a>
        <div class="nav-section-title mt-2">Compte</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link-item border-0 bg-transparent w-100 text-start" style="color:#f87171;">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <h6 class="mb-0 fw-bold">@yield('page-title', 'Tableau de bord')</h6>
        <div class="d-flex align-items-center gap-2">
            @if(session('success'))
                <span class="badge bg-success">{{ session('success') }}</span>
            @endif
            <span class="badge bg-purple" style="background:#0ea5e9!important;">Espace Super Admin</span>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
