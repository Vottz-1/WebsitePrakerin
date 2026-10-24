@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')

<style>
    html,
    body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
        overflow-x: hidden;
    }

    .welcome-page {
        width: 100%;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* =========================
       NAVBAR
    ========================= */
    .welcome-navbar {
        width: 100%;
        padding: 20px 0;
    }

    .welcome-navbar-inner {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* =========================
       HERO
    ========================= */
    .welcome-hero-section {
        width: 100%;
        padding: 45px 0 40px;
    }

    .welcome-hero {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto !important;
        padding: 0 20px;
    }

    .welcome-hero-copy {
        padding-left: 0;
        padding-right: 20px;
    }

    .welcome-hero-visual {
        padding-left: 20px;
        padding-right: 0;
    }

    .welcome-title {
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -1px;
    }

    .welcome-description {
        max-width: 570px;
        line-height: 1.65;
    }

    /* =========================
       PREVIEW CARD
    ========================= */
    .welcome-hero-visual {
        position: relative;
    }

    .welcome-float-wrapper {
        position: relative;
        z-index: 2;
    }

    .welcome-preview-card {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .welcome-glow {
        width: 350px;
        height: 350px;
        z-index: 0;
        filter: blur(70px);
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 991.98px) {

        .welcome-hero-section {
            padding-top: 30px;
        }

        .welcome-hero-copy {
            padding-left: 20px;
            padding-right: 20px;
            text-align: center !important;
        }

        .welcome-description {
            margin-left: auto;
            margin-right: auto;
        }

        .welcome-actions {
            justify-content: center !important;
        }

        .welcome-hero-visual {
            padding-left: 20px;
            padding-right: 20px;
        }

        .welcome-preview-card {
            max-width: 600px;
        }
    }

    @media (max-width: 575.98px) {

        .welcome-navbar-inner {
            padding: 0 15px;
        }

        .welcome-hero {
            padding-left: 15px;
            padding-right: 15px;
        }

        .welcome-title {
            font-size: 2.4rem;
        }

        .welcome-description {
            font-size: 1rem;
        }

        .welcome-preview-card {
            padding: 20px !important;
        }
    }
</style>


<div class="welcome-page">

    {{-- =========================
         NAVBAR
    ========================== --}}
    <nav class="navbar navbar-expand-lg navbar-light welcome-navbar">
        <div class="welcome-navbar-inner d-flex align-items-center">

            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark"
               href="{{ url('/') }}">

                <span
                    class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center"
                    style="width: 38px; height: 38px;">

                    <i class="fa-solid fa-graduation-cap"></i>

                </span>

                <span>E-Prakerin</span>

            </a>


            <div class="ms-auto d-flex align-items-center">

                <a href="{{ route('login') }}"
                   class="btn btn-outline-primary rounded-pill px-3">

                    <i class="fa-solid fa-right-to-bracket me-2"></i>
                    Masuk

                </a>

            </div>

        </div>
    </nav>


    {{-- =========================
         HERO SECTION
    ========================== --}}
    <section class="welcome-hero-section py-5 my-1 border-top">

        <div class="welcome-hero">

            <div class="row align-items-center justify-content-center g-5">


                {{-- =========================
                     HERO TEXT
                ========================== --}}
                <div class="col-12 col-lg-6 welcome-hero-copy">

                    <span
                        class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 mb-3 fw-semibold">

                        <i class="fa-solid fa-rocket me-2"></i>
                        Sistem Monitoring Magang Modern

                    </span>


                    <h1 class="display-4 fw-extrabold mb-3 text-dark brand-font welcome-title">

                        Kelola Kegiatan

                        <span class="text-primary bg-gradient">
                            Prakerin
                        </span>

                        Anda Secara Digital

                    </h1>


                    <p class="lead text-secondary mb-4 welcome-description">

                        E-Prakerin memudahkan siswa melakukan pendaftaran data diri
                        secara mandiri, memudahkan guru/admin melakukan validasi data,
                        serta mencatat jurnal kegiatan harian secara real-time dan
                        terstruktur.

                    </p>


                    {{-- BUTTON --}}
                    <div class="d-flex flex-wrap justify-content-start gap-3 welcome-actions">

                        @auth

                            <a href="{{ route('dashboard') }}"
                               class="btn btn-gradient-primary btn-lg rounded-pill px-4">

                                <i class="fa-solid fa-gauge-high me-2"></i>
                                Masuk Dashboard

                            </a>

                        @else

                            <a href="{{ route('register') }}"
                               class="btn btn-gradient-primary btn-lg rounded-pill px-4 shadow-sm">

                                <i class="fa-solid fa-user-plus me-2"></i>
                                Daftar Prakerin

                            </a>


                            <a href="{{ route('login') }}"
                               class="btn btn-outline-secondary btn-lg rounded-pill px-4">

                                <i class="fa-solid fa-right-to-bracket me-2"></i>
                                Masuk Akun

                            </a>

                        @endauth

                    </div>

                </div>


                {{-- =========================
                     HERO CARD
                ========================== --}}
                <div class="col-12 col-lg-6 text-center welcome-hero-visual">

                    <div class="position-relative d-inline-block p-2 p-md-4 w-100">

                        {{-- Glow Background --}}
                        <div
                            class="position-absolute translate-middle start-50 top-50 bg-primary opacity-10 rounded-circle welcome-glow">
                        </div>


                        <div class="welcome-float-wrapper">

                            <div class="premium-card p-3 p-md-4 mx-auto text-start welcome-preview-card">


                                {{-- CARD HEADER --}}
                                <div class="d-flex justify-content-between align-items-center mb-4 gap-2">

                                    <h5 class="mb-0 text-dark font-title">

                                        <i class="fa-solid fa-circle-check text-success me-2"></i>

                                        Status Magang

                                    </h5>


                                    <span class="badge-approved">

                                        <i class="fa-solid fa-check-double me-1"></i>

                                        Divalidasi

                                    </span>

                                </div>


                                {{-- NAMA --}}
                                <div class="mb-4">

                                    <small class="text-muted d-block mb-1">
                                        Nama Peserta
                                    </small>

                                    <strong class="fs-5 text-dark">
                                        Nama Lengkap Anda
                                    </strong>

                                </div>


                                {{-- SEKOLAH & JURUSAN --}}
                                <div class="row mb-4 g-3">

                                    <div class="col-6">

                                        <small class="text-muted d-block mb-1">
                                            Sekolah
                                        </small>

                                        <span class="text-dark fw-semibold">
                                            Asal Sekolah
                                        </span>

                                    </div>


                                    <div class="col-6">

                                        <small class="text-muted d-block mb-1">
                                            Jurusan
                                        </small>

                                        <span class="text-dark fw-semibold">
                                            Contoh: PPLG
                                        </span>

                                    </div>

                                </div>


                                {{-- JURNAL --}}
                                <div class="border-top pt-4">

                                    <h6 class="text-dark mb-3">

                                        <i class="fa-solid fa-list-check text-primary me-2"></i>

                                        Jurnal Terbaru

                                    </h6>


                                    <div
                                        class="p-3 bg-light rounded-3 mb-2 border-start border-primary border-3">

                                        <div
                                            class="d-flex justify-content-between align-items-center mb-1 gap-2 flex-wrap">

                                            <small class="fw-bold text-dark">
                                                Hari Ke-3
                                            </small>

                                            <small class="text-muted">
                                                15 Juli 2026
                                            </small>

                                        </div>


                                        <p class="small text-secondary mb-0">
                                            Artikel Kegiatan
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================
         ALUR E-PRAKERIN
    ========================== --}}
    <section class="py-5 my-5 border-top">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="font-title display-6">
                    Bagaimana Alur E-Prakerin Bekerja?
                </h2>

                <p class="text-secondary col-md-8 mx-auto">

                    Tiga langkah mudah untuk mendokumentasikan kegiatan
                    magang industri Anda secara profesional.

                </p>

            </div>


            <div class="row g-4 justify-content-center">


                {{-- STEP 1 --}}
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="premium-card p-4 text-center h-100 welcome-step-card">

                        <div
                            class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 70px; height: 70px;">

                            <i class="fa-solid fa-address-card fs-3 text-primary"></i>

                        </div>


                        <h4 class="font-title">
                            1. Registrasi (Komponen Diri)
                        </h4>


                        <p class="text-secondary small mb-0">

                            Siswa melakukan registrasi akun magang sekaligus
                            melengkapi data diri (komponen diri) seperti NISN,
                            sekolah, jurusan, dan tanggal pelaksanaan magang.

                        </p>

                    </div>

                </div>


                {{-- STEP 2 --}}
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="premium-card p-4 text-center h-100 welcome-step-card">

                        <div
                            class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 70px; height: 70px;">

                            <i class="fa-solid fa-user-shield fs-3 text-warning"></i>

                        </div>


                        <h4 class="font-title">
                            2. Validasi Data Admin
                        </h4>


                        <p class="text-secondary small mb-0">

                            Admin melakukan verifikasi dan peninjauan data siswa
                            yang mendaftar. Admin dapat menyetujui (Approve)
                            atau menolak (Reject) pendaftaran tersebut.

                        </p>

                    </div>

                </div>


                {{-- STEP 3 --}}
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="premium-card p-4 text-center h-100 welcome-step-card">

                        <div
                            class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 70px; height: 70px;">

                            <i class="fa-solid fa-file-pen fs-3 text-success"></i>

                        </div>


                        <h4 class="font-title">
                            3. Isi Jurnal Kegiatan
                        </h4>


                        <p class="text-secondary small mb-0">

                            Setelah data divalidasi oleh Admin, siswa dapat
                            mengakses fitur pengisian jurnal harian untuk
                            mencatat kegiatan praktik kerja industri mereka.

                        </p>

                    </div>

                </div>


            </div>

        </div>

    </section>

</div>

@endsection
