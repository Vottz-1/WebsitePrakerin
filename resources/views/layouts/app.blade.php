<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Sistem Informasi Prakerin</title>


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- FontAwesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Premium Custom Styles -->
    <style>

        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --secondary-gradient: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            --success-gradient: linear-gradient(135deg, #34d399 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #f87171 0%, #dc2626 100%);

            --glass-bg: rgba(255, 255, 255, 0.85);

            --body-bg: #f8fafc;

            --text-main: #1e293b;

            --text-muted: #64748b;
        }


        /* =========================
           GLOBAL
        ========================= */

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }


        body {
            font-family: 'Inter', sans-serif;

            background-color: var(--body-bg);

            color: var(--text-main);

            min-height: 100vh;

            overflow-x: hidden;

            display: flex;

            flex-direction: column;
        }


        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .brand-font {
            font-family: 'Outfit', sans-serif;

            font-weight: 600;
        }


        /* =========================
           APP SHELL
        ========================= */

        .app-shell {
            display: flex;

            width: 100%;

            min-height: 100vh;

            min-height: 100dvh;

            background: var(--body-bg);

            position: relative;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 260px;

            height: 100vh;

            height: 100dvh;

            background:
                linear-gradient(
                    145deg,
                    #0f172a 0%,
                    #111827 45%,
                    #312e81 100%
                );

            color: #f8fafc;

            padding: 18px 15px;

            display: flex;

            flex-direction: column;

            gap: 14px;

            box-shadow:
                10px 0 30px rgba(15, 23, 42, 0.16);

            overflow: hidden;

            transition:
                transform 0.3s ease,
                margin-left 0.3s ease;

            z-index: 1000;
        }


        .sidebar::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(129, 140, 248, 0.25),
                    transparent 38%
                );

            pointer-events: none;
        }


        .sidebar-brand {
            font-weight: 800;

            font-size: 1.05rem;

            color: #ffffff;

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 8px;

            position: relative;

            z-index: 1;

            padding: 2px 4px;

            white-space: nowrap;

            flex-shrink: 0;
        }


        .sidebar-header {
            position: relative;

            z-index: 1;

            flex-shrink: 0;
        }


        .sidebar-scroll-area {
            flex: 1 1 auto;

            min-height: 0;

            overflow-y: auto;

            overflow-x: hidden;

            padding-right: 4px;

            position: relative;

            z-index: 1;

            scrollbar-gutter: stable;

            padding-bottom: 8px;
        }


        .sidebar-scroll-area::-webkit-scrollbar {
            width: 6px;
        }


        .sidebar-scroll-area::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);

            border-radius: 999px;
        }


        .sidebar-brand i {
            color: #c7d2fe;

            font-size: 1rem;

            background: rgba(255, 255, 255, 0.12);

            padding: 8px;

            border-radius: 10px;
        }


        .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.72);

            font-size: 0.82rem;

            margin: 0;

            padding-left: 4px;

            position: relative;

            z-index: 1;
        }


        .sidebar-nav {
            display: flex;

            flex-direction: column;

            gap: 8px;

            margin-top: 8px;

            position: relative;

            z-index: 1;

            padding-bottom: 6px;
        }


        .sidebar-nav .nav-link {
            color: rgba(248, 250, 252, 0.92);

            border-radius: 12px;

            padding: 10px 12px;

            transition: all 0.25s ease;

            font-weight: 500;

            display: flex;

            align-items: center;

            border: 1px solid transparent;

            font-size: 0.93rem;

            white-space: nowrap;
        }


        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background:
                linear-gradient(
                    90deg,
                    rgba(129, 140, 248, 0.28),
                    rgba(59, 130, 246, 0.2)
                );

            color: #ffffff;

            border-color: rgba(255, 255, 255, 0.14);

            transform: translateX(4px);

            box-shadow:
                0 8px 18px rgba(15, 23, 42, 0.18);
        }


        .sidebar-heading {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.55);
            margin-top: 14px;
            margin-bottom: 6px;
            padding: 0 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }


        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            margin: 10px 4px;
        }


        /* =========================
           SIDEBAR USER
        ========================= */

        .sidebar-user-card {
            margin-top: auto;

            background: rgba(255, 255, 255, 0.1);

            border: 1px solid rgba(255, 255, 255, 0.16);

            border-radius: 14px;

            padding: 12px;

            backdrop-filter: blur(8px);

            position: relative;

            z-index: 1;

            flex-shrink: 0;
        }


        /* =========================
           CONTENT PANEL
        ========================= */

        .content-panel {
            flex: 1 1 auto;

            min-width: 0;

            display: flex;

            flex-direction: column;

            min-height: 100vh;

            min-height: 100dvh;

            transition:
                margin-left 0.3s ease,
                width 0.3s ease;
        }


        /* =========================
           TOPBAR
        ========================= */

        .content-topbar {
            display: flex;

            align-items: center;

            gap: 12px;

            min-height: 72px;

            padding: 0 24px;

            background: rgba(255, 255, 255, 0.9);

            backdrop-filter: blur(8px);

            border-bottom:
                1px solid rgba(226, 232, 240, 0.9);

            position: sticky;

            top: 0;

            z-index: 999;
        }


        .content-topbar .topbar-title {
            display: flex;

            flex-direction: column;

            line-height: 1.2;
        }


        .content-topbar .topbar-title span {
            font-size: 1rem;

            color: #0f172a;
        }


        .content-topbar .topbar-title small {
            font-size: 0.8rem;
        }


        /* =========================
           SIDEBAR TOGGLE
        ========================= */

        .sidebar-toggle {
            position: relative;

            width: 46px;

            height: 46px;

            border: none;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5 0%,
                    #7c3aed 100%
                );

            color: white;

            box-shadow:
                0 10px 24px rgba(79, 70, 229, 0.25);

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            flex-shrink: 0;
        }


        .sidebar-toggle:hover {
            transform: scale(1.04);
        }


        .sidebar-toggle i {
            font-size: 1.05rem;
        }


        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            flex: 1;

            padding: 24px 24px 40px;
        }


        .main-content .container {
            max-width: 100%;
        }


        /* =========================
           WELCOME
        ========================= */

        .welcome-hero {
            min-height: 520px;
        }


        .welcome-title {
            line-height: 1.2;

            max-width: 620px;
        }


        .welcome-description {
            max-width: 620px;
        }


        .welcome-glow {
            width: 400px;

            height: 400px;

            z-index: -1;

            filter: blur(50px);
        }


        .welcome-preview-card {
            width: min(100%, 480px);

            max-width: 480px;

            border-radius: 24px !important;

            border:
                1px solid rgba(255, 255, 255, 0.7);

            background:
                rgba(255, 255, 255, 0.85);

            backdrop-filter: blur(10px);
        }


        .welcome-step-card {
            min-height: 100%;
        }


        /* =========================
           PREMIUM CARDS
        ========================= */

        .premium-card {
            background: #ffffff;

            border:
                1px solid rgba(226, 232, 240, 0.8);

            border-radius: 16px;

            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.03);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .premium-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 20px 40px rgba(15, 23, 42, 0.06);
        }


        /* =========================
           WELCOME FLOATING CARD
        ========================= */

        @keyframes premium-float {

            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }

            100% {
                transform: translateY(0);
            }

        }


        .welcome-float-wrapper {
            display: block;

            animation:
                premium-float 6s ease-in-out infinite;
        }


        .welcome-preview-card {
            border-radius: 24px !important;

            overflow: hidden;

            box-shadow:
                0 20px 40px rgba(99, 102, 241, 0.12),
                0 1px 3px rgba(0, 0, 0, 0.05) !important;

            transition:
                transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.4s ease !important;
        }


        .welcome-preview-card:hover {
            transform: scale(1.025) !important;

            box-shadow:
                0 30px 60px rgba(99, 102, 241, 0.22),
                0 2px 8px rgba(0, 0, 0, 0.06) !important;
        }


        /* =========================
           BUTTONS
        ========================= */

        .btn-gradient-primary {
            background: var(--primary-gradient);

            color: #ffffff;

            border: none;

            border-radius: 10px;

            padding: 10px 20px;

            font-weight: 500;

            transition: all 0.2s ease;
        }


        .btn-gradient-primary:hover {
            opacity: 0.95;

            transform: scale(1.02);

            color: #ffffff;
        }


        .btn-gradient-success {
            background: var(--success-gradient);

            color: #ffffff;

            border: none;

            border-radius: 10px;

            padding: 10px 20px;

            font-weight: 500;

            transition: all 0.2s ease;
        }


        .btn-gradient-success:hover {
            opacity: 0.95;

            transform: scale(1.02);

            color: #ffffff;
        }


        .btn-gradient-danger {
            background: var(--danger-gradient);

            color: #ffffff;

            border: none;

            border-radius: 10px;

            padding: 10px 20px;

            font-weight: 500;

            transition: all 0.2s ease;
        }


        .btn-gradient-danger:hover {
            opacity: 0.95;

            transform: scale(1.02);

            color: #ffffff;
        }


        /* =========================
           BADGES
        ========================= */

        .badge-pending {
            display: inline-flex;

            align-items: center;

            white-space: nowrap;

            background-color:
                rgba(251, 191, 36, 0.15);

            color: #d97706;

            border:
                1px solid rgba(251, 191, 36, 0.3);

            border-radius: 30px;

            padding: 6px 14px;

            font-weight: 600;

            font-size: 0.85rem;
        }


        .badge-approved {
            display: inline-flex;

            align-items: center;

            white-space: nowrap;

            background-color:
                rgba(52, 211, 153, 0.15);

            color: #059669;

            border:
                1px solid rgba(52, 211, 153, 0.3);

            border-radius: 30px;

            padding: 6px 14px;

            font-weight: 600;

            font-size: 0.85rem;
        }


        .badge-rejected {
            display: inline-flex;

            align-items: center;

            white-space: nowrap;

            background-color:
                rgba(248, 113, 113, 0.15);

            color: #dc2626;

            border:
                1px solid rgba(248, 113, 113, 0.3);

            border-radius: 30px;

            padding: 6px 14px;

            font-weight: 600;

            font-size: 0.85rem;
        }


        /* =========================
           STAT CARD
        ========================= */

        .stat-card {
            border-radius: 16px;

            border: none;

            color: white;

            padding: 24px;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);

            transition: transform 0.2s;
        }


        .stat-card:hover {
            transform: translateY(-3px);
        }


        .stat-card.primary {
            background: var(--primary-gradient);
        }


        .stat-card.success {
            background: var(--success-gradient);
        }


        .stat-card.warning {
            background: var(--warning-gradient);
        }


        .stat-card.danger {
            background: var(--danger-gradient);
        }


        .stat-card-icon {
            font-size: 2.2rem;

            opacity: 0.8;
        }


        /* =========================
           TABLE
        ========================= */

        .table-responsive {
            border-radius: 16px;

            border:
                1px solid rgba(226, 232, 240, 0.8);

            background: white;
        }


        .custom-table th {
            background-color: #f8fafc;

            color: #475569;

            font-weight: 600;

            border-bottom:
                2px solid #e2e8f0;

            padding: 16px 20px;
        }


        .custom-table td {
            padding: 16px 20px;

            vertical-align: middle;

            border-bottom:
                1px solid #f1f5f9;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            margin-top: auto;

            background: #ffffff;

            border-top:
                1px solid #e2e8f0;

            padding: 20px 0;

            font-size: 0.9rem;

            color: var(--text-muted);
        }


        /* =========================
           ALERT
        ========================= */

        .alert {
            border-radius: 12px;

            border: none;

            padding: 15px 20px;
        }


        /* =========================
           FORM
        ========================= */

        .form-control:focus,
        .form-select:focus {
            border-color:
                #6366f1 !important;

            box-shadow:
                0 0 0 0.25rem
                rgba(99, 102, 241, 0.18) !important;
        }


        label:has(~ input[required])::after,
        label:has(~ select[required])::after,
        label:has(~ textarea[required])::after,
        .form-label:has(~ input[required])::after,
        .form-label:has(~ select[required])::after,
        .form-label:has(~ textarea[required])::after,
        .required::after {
            content: " *";

            color: #ef4444;

            font-weight: 600;

            margin-left: 2px;
        }


        /* ==================================================
           DESKTOP
           ================================================== */

        @media (min-width: 992px) {

            /* Sidebar tetap fixed */

            .sidebar {
                position: fixed;

                top: 0;

                bottom: 0;

                left: 0;
            }


            /*
             * HALAMAN DENGAN SIDEBAR
             *
             * Contoh:
             * Dashboard
             * Admin
             * Data Absensi
             * Tambah Prakerin
             */

            .content-panel.has-sidebar {
                margin-left: 260px;

                width: calc(100% - 260px);
            }


            /*
             * HALAMAN TANPA SIDEBAR
             *
             * Contoh:
             * Welcome
             * Login
             * Register
             *
             * Tidak ada lagi margin-left 260px.
             */

            .content-panel.no-sidebar {
                margin-left: 0;

                width: 100%;
            }


            /* Sidebar collapsed */

            .sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }


            .sidebar-collapsed .content-panel.has-sidebar {
                margin-left: 0;

                width: 100%;
            }


            /*
             * Jika sidebar tidak ada,
             * collapsed tidak memberikan efek
             * apapun terhadap layout.
             */

            .sidebar-collapsed .content-panel.no-sidebar {
                margin-left: 0;

                width: 100%;
            }

        }


        /* ==================================================
           TABLET & MOBILE
           ================================================== */

        @media (max-width: 991.98px) {

            body {
                height: auto;

                overflow: auto;
            }


            .app-shell {
                flex-direction: column;
            }


            .sidebar {
                position: static;

                width: 100%;

                height: auto;

                min-height: auto;

                border-radius:
                    0 0 20px 20px;
            }


            .sidebar-scroll-area {
                overflow: visible;
            }


            .sidebar-user-card {
                margin-top: 12px;
            }


            .content-panel,
            .content-panel.has-sidebar,
            .content-panel.no-sidebar {
                margin-left: 0;

                width: 100%;

                min-height: auto;
            }


            .content-topbar {
                min-height: 66px;

                padding: 0 16px;
            }


            .sidebar-nav {
                flex-direction: row;

                flex-wrap: wrap;
            }


            .sidebar-nav .nav-link {
                flex: 1 1 140px;
            }


            .main-content {
                padding: 18px;
            }


            /* Welcome */

            .welcome-hero {
                min-height: auto;
            }


            .welcome-title {
                max-width: 100%;
            }


            .welcome-description {
                max-width: 100%;
            }

        }


        /* ==================================================
           MOBILE
           ================================================== */

        @media (max-width: 767.98px) {

            .welcome-actions {
                width: 100%;
            }


            .welcome-actions .btn {
                flex: 1 1 100%;

                width: 100%;

                justify-content: center;
            }


            .welcome-preview-card {
                max-width: 100%;
            }


            .welcome-glow {
                width: 260px;

                height: 260px;
            }

        }

    </style>

</head>


<body>

    @php

        /*
         * Sidebar hanya muncul ketika user login.
         */

        $showSidebar = Auth::check();

    @endphp


    <div class="app-shell" id="appShell">


        {{-- ==================================================
             SIDEBAR
             ================================================== --}}

        @if($showSidebar)

            <aside class="sidebar">


                {{-- SIDEBAR HEADER --}}

                <div class="sidebar-header">

                    <a
                        class="sidebar-brand"
                        href="{{ url('/') }}"
                    >

                        <i class="fa-solid fa-graduation-cap"></i>

                        <span>
                            E-Prakerin
                        </span>

                    </a>


                    <p class="sidebar-subtitle">
                        Sistem Informasi Prakerin
                    </p>

                </div>


                {{-- SIDEBAR MENU --}}

                <div class="sidebar-scroll-area">

                    <ul class="sidebar-nav nav">

                        @auth

                            {{-- Menu Utama --}}
                            <div class="sidebar-heading">
                                <i class="fa-solid fa-compass me-1"></i> Menu Utama
                            </div>

                            {{-- Dashboard --}}
                            <li class="nav-item">
                                <a
                                    class="nav-link {{ Request::is('dashboard') || Request::is('admin') || (Request::is('prakerin') && !Request::is('prakerin/*')) ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}"
                                >
                                    <i class="fa-solid fa-chart-line me-2 text-primary"></i>
                                    Dashboard
                                </a>
                            </li>


                            {{-- Absensi Prakerin (User Siswa) --}}
                            @if(Auth::user()->isPrakerin())
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ Request::is('prakerin/attendance') ? 'active' : '' }}"
                                        href="{{ route('prakerin.attendance') }}"
                                    >
                                        <i class="fa-solid fa-clipboard-user me-2 text-info"></i>
                                        Absensi
                                    </a>
                                </li>
                            @endif


                            {{-- Menu Admin --}}
                            @if(Auth::user()->isAdmin())
                                {{-- Data Absensi Admin --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ Request::is('admin/attendances*') ? 'active' : '' }}"
                                        href="{{ route('admin.attendances') }}"
                                    >
                                        <i class="fa-solid fa-clipboard-user me-2 text-info"></i>
                                        Data Absensi
                                    </a>
                                </li>

                                {{-- Tambah Prakerin --}}
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ Request::is('admin/prakerin/create') ? 'active' : '' }}"
                                        href="{{ route('admin.prakerin.create') }}"
                                    >
                                        <i class="fa-solid fa-user-plus me-2 text-success"></i>
                                        Tambah Prakerin
                                    </a>
                                </li>
                            @endif


                        @else

                            {{-- Login --}}

                            <li class="nav-item">

                                <a
                                    class="nav-link {{ Request::is('login') ? 'active' : '' }}"
                                    href="{{ route('login') }}"
                                >

                                    <i class="fa-solid fa-right-to-bracket me-2"></i>

                                    Masuk

                                </a>

                            </li>


                            {{-- Register --}}

                            <li class="nav-item">

                                <a
                                    class="nav-link btn btn-gradient-primary rounded-pill px-3 mt-2 text-start"
                                    href="{{ route('register') }}"
                                >

                                    <i class="fa-solid fa-user-plus me-2"></i>

                                    Daftar Prakerin

                                </a>

                            </li>

                        @endauth

                    </ul>

                </div>


                {{-- USER CARD --}}

                @auth

                    <div class="sidebar-user-card">

                        <div class="d-flex align-items-center gap-2 mb-2">

                            <i class="fa-solid fa-circle-user text-primary fs-5"></i>

                            <div>

                                <div class="fw-semibold">
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="small text-white-50 text-capitalize">
                                    {{ Auth::user()->role }}
                                </div>

                            </div>

                        </div>


                        {{-- Logout --}}

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-light btn-sm w-100 mt-2 rounded-pill"
                            >

                                <i class="fa-solid fa-right-from-bracket me-2"></i>

                                Keluar

                            </button>

                        </form>

                    </div>

                @endauth

            </aside>

        @endif


        {{-- ==================================================
             CONTENT PANEL
             ================================================== --}}

        <div
            class="content-panel {{ $showSidebar ? 'has-sidebar' : 'no-sidebar' }}"
        >


            {{-- ==================================================
                 TOPBAR
                 Hanya muncul ketika sidebar aktif
                 ================================================== --}}

            @if($showSidebar)

                <div class="content-topbar">

                    <button
                        class="sidebar-toggle"
                        type="button"
                        id="sidebarToggle"
                        aria-label="Buka/tutup sidebar"
                    >

                        <i class="fa-solid fa-bars"></i>

                    </button>


                    <div class="topbar-title">

                        <span>
                            @yield('title')
                        </span>

                        <small class="text-muted">
                            Panel Administrasi
                        </small>

                    </div>

                </div>

            @endif


            {{-- ==================================================
                 MAIN CONTENT
                 ================================================== --}}

            <main class="main-content">

                <div class="container">


                    {{-- SUCCESS ALERT --}}

                    @if(session('success'))

                        <div
                            class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center gap-3"
                            role="alert"
                        >

                            <i class="fa-solid fa-circle-check fs-4"></i>


                            <div>

                                {{ session('success') }}

                            </div>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    @endif


                    {{-- ERROR ALERT --}}

                    @if($errors->any() && !Request::is('login') && !Request::is('register'))

                        <div
                            class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center gap-3"
                            role="alert"
                        >

                            <i class="fa-solid fa-circle-exclamation fs-4"></i>


                            <div>

                                <ul class="mb-0 ps-3">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    @endif


                    {{-- PAGE CONTENT --}}

                    @yield('content')


                </div>

            </main>


            {{-- ==================================================
                 FOOTER
                 ================================================== --}}

            <footer>

                <div class="container text-center">

                    <p class="mb-0">

                        &copy;
                        {{ date('Y') }}
                        PKL Stikom 2026

                    </p>

                </div>

            </footer>


        </div>

    </div>


    <!-- Bootstrap Bundle JS with Popper -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /* =========================
               ELEMENT
            ========================= */

            const toggleButton =
                document.getElementById('sidebarToggle');

            const appShell =
                document.getElementById('appShell');

            const storageKey =
                'sidebarCollapsed';


            /* =========================
               UPDATE TOGGLE ICON
            ========================= */

            function updateToggleIcon() {

                if (!toggleButton) {
                    return;
                }


                const icon =
                    toggleButton.querySelector('i');


                if (!icon) {
                    return;
                }


                const isCollapsed =
                    appShell.classList.contains(
                        'sidebar-collapsed'
                    );


                icon.className =
                    isCollapsed
                        ? 'fa-solid fa-bars'
                        : 'fa-solid fa-xmark';

            }


            /* =========================
               SYNC SIDEBAR LAYOUT
            ========================= */

            function syncSidebarLayout() {

                const sidebar =
                    appShell
                        ? appShell.querySelector('.sidebar')
                        : null;


                const scrollArea =
                    sidebar
                        ? sidebar.querySelector(
                            '.sidebar-scroll-area'
                        )
                        : null;


                if (!sidebar || !scrollArea) {
                    return;
                }


                sidebar.style.removeProperty('height');

                scrollArea.style.removeProperty('height');

                scrollArea.style.removeProperty(
                    'max-height'
                );

            }


            /* =========================
               SIDEBAR STATE
            ========================= */

            if (toggleButton && appShell) {


                const savedState =
                    localStorage.getItem(
                        storageKey
                    ) === 'true';


                if (savedState) {

                    appShell.classList.add(
                        'sidebar-collapsed'
                    );

                } else {

                    appShell.classList.remove(
                        'sidebar-collapsed'
                    );

                }


                updateToggleIcon();

                syncSidebarLayout();


                /* =========================
                   TOGGLE SIDEBAR
                ========================= */

                toggleButton.addEventListener(
                    'click',
                    function () {


                        const isCollapsed =
                            appShell.classList.toggle(
                                'sidebar-collapsed'
                            );


                        localStorage.setItem(
                            storageKey,
                            isCollapsed
                                ? 'true'
                                : 'false'
                        );


                        updateToggleIcon();

                        syncSidebarLayout();

                    }
                );

            }


            /* =========================
               RESIZE
            ========================= */

            window.addEventListener(
                'resize',
                syncSidebarLayout
            );

        });

    </script>


</body>

</html>
