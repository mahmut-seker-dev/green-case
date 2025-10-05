<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Green Case')</title>

    {{-- ✅ Vite ile SCSS + JS bundle --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="app-layout">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-building-fill-gear fs-4"></i> Green Case
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    
                    <!-- Theme Toggle -->
                    <li class="nav-item me-lg-2">
                        <button class="btn btn-sm btn-outline-light theme-toggle" id="themeToggle" title="Tema Değiştir">
                            <i class="bi bi-sun-fill theme-icon-light"></i>
                            <i class="bi bi-moon-fill theme-icon-dark d-none"></i>
                        </button>
                    </li>
                    <!-- Ortak Menüler -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}"
                            href="{{ route('customers.index') }}">
                            <i class="bi bi-people-fill me-1"></i> Müşteriler
                        </a>
                    </li>

                    <!-- Silinen Kayıtlar - Sadece Admin -->
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="trashMenu"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-recycle me-1"></i> Silinen Kayıtlar
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0 rounded-3 mt-2"
                                aria-labelledby="trashMenu">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ route('trash.customers') }}">
                                        <i class="fa fa-user-slash text-danger"></i> Silinen Müşteriler
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ route('trash.users') }}">
                                        <i class="fa fa-users-slash text-info"></i> Silinen Kullanıcılar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <!-- Kullanıcılar - Admin ve Manager -->
                    @if (in_array(Auth::user()->role, ['admin', 'manager']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <i class="bi bi-person-lines-fill me-1"></i> Kullanıcılar
                            </a>
                        </li>
                    @endif

                    <!-- Sağ Taraf: Kullanıcı Menüsü -->
                    @auth
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=198754&color=fff&size=32"
                                    class="rounded-circle me-2" alt="Avatar">
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3"
                                aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i> Profil
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Çıkış Yap
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Toast Container -->
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>
    </div>

    @stack('scripts')
</body>

</html>
