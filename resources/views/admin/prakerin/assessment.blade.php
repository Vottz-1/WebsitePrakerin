@extends('layouts.app')

@section('title', 'Penilaian Prakerin')

@section('content')
@php
    $studentDept = strtolower($student->prakerinProfile->department ?? '');
    if (str_contains($studentDept, 'rpl') || str_contains($studentDept, 'perangkat') || str_contains($studentDept, 'software') || str_contains($studentDept, 'rekayasa')) {
        $detectedDept = 'rpl';
    } elseif (str_contains($studentDept, 'dkv') || str_contains($studentDept, 'desain') || str_contains($studentDept, 'visual') || str_contains($studentDept, 'multimedia') || str_contains($studentDept, 'grafika') || str_contains($studentDept, 'animasi')) {
        $detectedDept = 'dkv';
    } else {
        $detectedDept = 'tkj';
    }

    // If assessment already saved, detect based on stored keys
    if (isset($assessment->technical_scores['system_design']) || isset($assessment->technical_scores['web_development'])) {
        $detectedDept = 'rpl';
    } elseif (isset($assessment->technical_scores['vector_design']) || isset($assessment->technical_scores['raster_editing'])) {
        $detectedDept = 'dkv';
    } elseif (isset($assessment->technical_scores['os_installation']) || isset($assessment->technical_scores['troubleshooting'])) {
        $detectedDept = 'tkj';
    }
@endphp

<div class="row">
    <div class="col-12">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Student Brief Info Banner -->
        <div class="premium-card p-4 mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
            <div class="row align-items-center g-3">
                <div class="col-md-auto text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center fw-bold text-primary display-6" style="width: 75px; height: 75px;">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                </div>
                <div class="col-md">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <h3 class="mb-0 font-title text-dark">#{{ $student->id }} - {{ $student->name }}</h3>
                        @if(optional($student->prakerinProfile)->status === 'pending')
                            <span class="badge-pending"><i class="fa-regular fa-clock me-1"></i>Menunggu</span>
                        @elseif(optional($student->prakerinProfile)->status === 'approved')
                            <span class="badge-approved"><i class="fa-regular fa-circle-check me-1"></i>Disetujui</span>
                        @else
                            <span class="badge-rejected"><i class="fa-regular fa-circle-xmark me-1"></i>Ditolak</span>
                        @endif
                    </div>
                    <p class="text-secondary mb-2"><i class="fa-solid fa-envelope me-2"></i>{{ $student->email }}</p>
                    <div class="d-flex flex-wrap gap-x-4 gap-y-1 small text-secondary">
                        <span class="me-3"><i class="fa-solid fa-school me-1"></i> Asal: <b>{{ $student->prakerinProfile->school ?? '-' }}</b></span>
                        <span class="me-3"><i class="fa-solid fa-address-card me-1"></i> NISN: <b>{{ $student->prakerinProfile->nisn ?? '-' }}</b></span>
                        <span class="me-3">
                            <i class="fa-solid fa-graduation-cap me-1"></i> Jurusan:
                            <span class="badge {{ $detectedDept === 'rpl' ? 'bg-primary-subtle text-primary' : ($detectedDept === 'dkv' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-info-subtle text-info-emphasis') }} border rounded-pill px-2 py-1 fw-bold">
                                {{ $student->prakerinProfile->department ?? ($detectedDept === 'rpl' ? 'Rekayasa Perangkat Lunak (RPL)' : ($detectedDept === 'dkv' ? 'Desain Komunikasi Visual (DKV)' : 'Teknik Komputer & Jaringan (TKJ)')) }}
                            </span>
                        </span>
                        @if(optional($student->prakerinProfile)->start_date && optional($student->prakerinProfile)->end_date)
                            <span><i class="fa-regular fa-calendar-days me-1"></i> Periode: <b>{{ \Carbon\Carbon::parse($student->prakerinProfile->start_date)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($student->prakerinProfile->end_date)->translatedFormat('d M Y') }}</b></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-5"></i>
                <div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Penilaian -->
        <form action="{{ route('admin.prakerin.assessment.store', $student->id) }}" method="POST" id="assessmentForm">
            @csrf

            <!-- 2 Card Bersebelahan -->
            <div class="row g-4 mb-4">
                <!-- Card 1: Aspek Teknik (Khusus Jurusan TKJ, RPL & DKV) -->
                <div class="col-lg-6">
                    <div class="premium-card p-4 h-100 shadow-sm border-0 border-top border-4 border-primary">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
                            <div>
                                <h5 class="font-title text-dark mb-0">
                                    <i class="fa-solid fa-laptop-code text-primary me-2"></i>Aspek Teknik
                                </h5>
                                <small class="text-muted">Kompetensi Kejuruan</small>
                            </div>
                            <!-- Tab Switcher Jurusan -->
                            <div class="btn-group btn-group-sm" role="group" aria-label="Pilih Jurusan">
                                <button type="button"
                                        class="btn btn-sm rounded-start-pill px-3 py-1 fw-semibold {{ $detectedDept === 'tkj' ? 'btn-primary' : 'btn-outline-primary' }}"
                                        id="btnTabTKJ"
                                        onclick="switchDept('tkj')">
                                    <i class="fa-solid fa-network-wired me-1"></i> TKJ
                                </button>
                                <button type="button"
                                        class="btn btn-sm px-3 py-1 fw-semibold {{ $detectedDept === 'rpl' ? 'btn-primary' : 'btn-outline-primary' }}"
                                        id="btnTabRPL"
                                        onclick="switchDept('rpl')">
                                    <i class="fa-solid fa-code me-1"></i> RPL
                                </button>
                                <button type="button"
                                        class="btn btn-sm rounded-end-pill px-3 py-1 fw-semibold {{ $detectedDept === 'dkv' ? 'btn-primary' : 'btn-outline-primary' }}"
                                        id="btnTabDKV"
                                        onclick="switchDept('dkv')">
                                    <i class="fa-solid fa-palette me-1"></i> DKV
                                </button>
                            </div>
                        </div>

                        <!-- Header Info Jurusan Aktif -->
                        <div class="alert alert-light border rounded-3 p-2 mb-3 d-flex align-items-center justify-content-between" style="font-size: 0.82rem;">
                            <span class="text-secondary">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i> Aspek khusus:
                                <strong id="activeDeptLabel" class="text-dark">
                                    @if($detectedDept === 'rpl')
                                        Rekayasa Perangkat Lunak (RPL)
                                    @elseif($detectedDept === 'dkv')
                                        Desain Komunikasi Visual (DKV)
                                    @else
                                        Teknik Komputer & Jaringan (TKJ)
                                    @endif
                                </strong>
                            </span>
                            <span class="badge bg-primary text-white" id="badgeDeptActive">{{ strtoupper($detectedDept) }}</span>
                        </div>

                        <!-- =========================
                             KOMPETENSI TEKNIK TKJ
                        ========================= -->
                        <div id="sectionTKJ" style="{{ $detectedDept === 'tkj' ? '' : 'display: none;' }}">
                            <div class="vstack gap-3">
                                <!-- 1. Instalasi Sistem Operasi Dasar -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_os" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-compact-disc text-primary me-1"></i> 1. Instalasi Sistem Operasi Dasar <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[os_installation]"
                                               id="tech_tkj_os"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.os_installation') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.os_installation', $assessment->technical_scores['os_installation'] ?? ($detectedDept === 'tkj' ? ($assessment->skill_score ?? '') : '')) }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 2. Troubleshooting Hardware & Software -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_troubleshoot" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-wrench text-warning me-1"></i> 2. Melakukan Troubleshooting <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[troubleshooting]"
                                               id="tech_tkj_troubleshoot"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.troubleshooting') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.troubleshooting', $assessment->technical_scores['troubleshooting'] ?? '') }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 3. Perakitan & Perawatan PC (Hardware) -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_pc" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-microchip text-info me-1"></i> 3. Perakitan & Perawatan PC (Hardware) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[pc_assembly]"
                                               id="tech_tkj_pc"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.pc_assembly') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.pc_assembly', $assessment->technical_scores['pc_assembly'] ?? '') }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 4. Pengkabelan & Instalasi Jaringan LAN -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_cabling" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-network-wired text-success me-1"></i> 4. Pengkabelan & Instalasi Jaringan LAN <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[lan_cabling]"
                                               id="tech_tkj_cabling"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.lan_cabling') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.lan_cabling', $assessment->technical_scores['lan_cabling'] ?? '') }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 5. Konfigurasi Router & Jaringan Nirkabel -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_network" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-wifi text-danger me-1"></i> 5. Konfigurasi Router & Jaringan Nirkabel <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[network_config]"
                                               id="tech_tkj_network"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.network_config') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.network_config', $assessment->technical_scores['network_config'] ?? '') }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 6. Administrasi Layanan Jaringan & Server Dasar -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_tkj_services" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-server text-secondary me-1"></i> 6. Administrasi Layanan Jaringan & Server Dasar <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[network_services]"
                                               id="tech_tkj_services"
                                               class="form-control rounded-start-2 tech-score-input-tkj @error('technical_scores.network_services') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.network_services', $assessment->technical_scores['network_services'] ?? '') }}"
                                               {{ $detectedDept === 'tkj' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =========================
                             KOMPETENSI TEKNIK RPL
                        ========================= -->
                        <div id="sectionRPL" style="{{ $detectedDept === 'rpl' ? '' : 'display: none;' }}">
                            <div class="vstack gap-3">
                                <!-- 1. Analisis Kebutuhan & Desain UI/UX -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_design" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-pen-ruler text-primary me-1"></i> 1. Analisis Sistem & Desain UI/UX <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[system_design]"
                                               id="tech_rpl_design"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.system_design') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.system_design', $assessment->technical_scores['system_design'] ?? ($detectedDept === 'rpl' ? ($assessment->skill_score ?? '') : '')) }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 2. Pemrograman Web & Logika Backend -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_web" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-code text-success me-1"></i> 2. Pemrograman Web & Logika Backend <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[web_development]"
                                               id="tech_rpl_web"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.web_development') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.web_development', $assessment->technical_scores['web_development'] ?? '') }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 3. Pengelolaan Basis Data (Database) -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_db" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-database text-warning me-1"></i> 3. Pengelolaan Basis Data (Database) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[database_management]"
                                               id="tech_rpl_db"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.database_management') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.database_management', $assessment->technical_scores['database_management'] ?? '') }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 4. Pemrograman Berorientasi Objek (OOP) -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_oop" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-cubes text-info me-1"></i> 4. Pemrograman Berorientasi Objek (OOP) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[oop_programming]"
                                               id="tech_rpl_oop"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.oop_programming') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.oop_programming', $assessment->technical_scores['oop_programming'] ?? '') }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 5. Testing & Debugging Program -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_testing" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-bug-slash text-danger me-1"></i> 5. Testing & Debugging Program <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[testing_debugging]"
                                               id="tech_rpl_testing"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.testing_debugging') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.testing_debugging', $assessment->technical_scores['testing_debugging'] ?? '') }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 6. Version Control (Git) & Deployment -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_rpl_git" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-cloud-arrow-up text-secondary me-1"></i> 6. Version Control (Git) & Deployment <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[git_deployment]"
                                               id="tech_rpl_git"
                                               class="form-control rounded-start-2 tech-score-input-rpl @error('technical_scores.git_deployment') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.git_deployment', $assessment->technical_scores['git_deployment'] ?? '') }}"
                                               {{ $detectedDept === 'rpl' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =========================
                             KOMPETENSI TEKNIK DKV
                        ========================= -->
                        <div id="sectionDKV" style="{{ $detectedDept === 'dkv' ? '' : 'display: none;' }}">
                            <div class="vstack gap-3">
                                <!-- 1. Desain Grafis Berbasis Vektor -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_vector" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-bezier-curve text-primary me-1"></i> 1. Desain Grafis Berbasis Vektor (Vector Design) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[vector_design]"
                                               id="tech_dkv_vector"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.vector_design') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.vector_design', $assessment->technical_scores['vector_design'] ?? ($detectedDept === 'dkv' ? ($assessment->skill_score ?? '') : '')) }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 2. Pengolahan Citra Digital & Foto Bitmap -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_raster" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-wand-magic-sparkles text-success me-1"></i> 2. Pengolahan Citra Digital & Bitmap (Photo Editing) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[raster_editing]"
                                               id="tech_dkv_raster"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.raster_editing') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.raster_editing', $assessment->technical_scores['raster_editing'] ?? '') }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 3. Tipografi & Tata Letak (Layout) -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_layout" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-font text-warning me-1"></i> 3. Tipografi & Tata Letak Media (Typography & Layout) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[typography_layout]"
                                               id="tech_dkv_layout"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.typography_layout') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.typography_layout', $assessment->technical_scores['typography_layout'] ?? '') }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 4. Desain Identitas Visual & Branding -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_branding" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-palette text-info me-1"></i> 4. Desain Identitas Visual & Branding (Brand Identity) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[branding_identity]"
                                               id="tech_dkv_branding"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.branding_identity') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.branding_identity', $assessment->technical_scores['branding_identity'] ?? '') }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 5. Ilustrasi Digital & Konten Kreatif -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_illustration" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-paint-brush text-danger me-1"></i> 5. Ilustrasi Digital & Konten Kreatif Media Sosial <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[digital_illustration]"
                                               id="tech_dkv_illustration"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.digital_illustration') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.digital_illustration', $assessment->technical_scores['digital_illustration'] ?? '') }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>

                                <!-- 6. Audio-Video Editing & Final Artwork -->
                                <div class="p-3 bg-light rounded-3 border">
                                    <label for="tech_dkv_video" class="form-label fw-semibold text-dark mb-0 small">
                                        <i class="fa-solid fa-film text-secondary me-1"></i> 6. Audio-Video Editing & Final Artwork Cetak/Digital <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="number"
                                               name="technical_scores[audio_video_motion]"
                                               id="tech_dkv_video"
                                               class="form-control rounded-start-2 tech-score-input-dkv @error('technical_scores.audio_video_motion') is-invalid @enderror"
                                               min="0"
                                               max="100"
                                               placeholder="Skala 0 - 100"
                                               value="{{ old('technical_scores.audio_video_motion', $assessment->technical_scores['audio_video_motion'] ?? '') }}"
                                               {{ $detectedDept === 'dkv' ? 'required' : 'disabled' }}>
                                        <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Live Technical Average Indicator -->
                        <div class="alert alert-primary bg-primary bg-opacity-10 border-primary-subtle text-primary rounded-3 p-3 mt-4 mb-0 d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold">
                                <i class="fa-solid fa-calculator me-1"></i> Estimasi Rata-rata Aspek Teknik:
                            </span>
                            <span class="fs-5 fw-bold" id="liveTechAverage">
                                {{ $assessment->skill_score ?? '0' }} / 100
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Aspek Non-Teknik (Sikap & Perilaku - 7 Nilai) -->
                <div class="col-lg-6">
                    <div class="premium-card p-4 h-100 shadow-sm border-0 border-top border-4 border-success">
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
                            <div>
                                <h5 class="font-title text-dark mb-0">
                                    <i class="fa-solid fa-user-check text-success me-2"></i>Aspek Non-Teknik
                                </h5>
                                <small class="text-muted">Sikap & Perilaku Kerja</small>
                            </div>
                        </div>

                        <div class="vstack gap-3">
                            <!-- 1. Sikap -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_attitude" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-heart-circle-check text-success me-1"></i> 1. Sikap (Attitude) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[attitude]"
                                           id="nontech_attitude"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.attitude') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.attitude', $assessment->non_technical_scores['attitude'] ?? ($assessment->attitude_score ?? '')) }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 2. Kerajinan -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_diligence" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-fire text-warning me-1"></i> 2. Kerajinan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[diligence]"
                                           id="nontech_diligence"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.diligence') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.diligence', $assessment->non_technical_scores['diligence'] ?? '') }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 3. Kedisiplinan -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_discipline" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-business-time text-primary me-1"></i> 3. Kedisiplinan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[discipline]"
                                           id="nontech_discipline"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.discipline') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.discipline', $assessment->non_technical_scores['discipline'] ?? ($assessment->discipline_score ?? '')) }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 4. Inisiatif dan Kreativitas -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_initiative" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-lightbulb text-warning me-1"></i> 4. Inisiatif dan Kreativitas <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[initiative_creativity]"
                                           id="nontech_initiative"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.initiative_creativity') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.initiative_creativity', $assessment->non_technical_scores['initiative_creativity'] ?? '') }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 5. Tanggung Jawab -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_responsibility" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-shield-halved text-info me-1"></i> 5. Tanggung Jawab <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[responsibility]"
                                           id="nontech_responsibility"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.responsibility') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.responsibility', $assessment->non_technical_scores['responsibility'] ?? '') }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 6. Kejujuran -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_honesty" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-hand-holding-heart text-danger me-1"></i> 6. Kejujuran <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[honesty]"
                                           id="nontech_honesty"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.honesty') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.honesty', $assessment->non_technical_scores['honesty'] ?? '') }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>

                            <!-- 7. Kerja Sama -->
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="nontech_teamwork" class="form-label fw-semibold text-dark mb-0 small">
                                    <i class="fa-solid fa-people-group text-success me-1"></i> 7. Kerja Sama <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="non_technical_scores[teamwork]"
                                           id="nontech_teamwork"
                                           class="form-control rounded-start-2 non-tech-score-input @error('non_technical_scores.teamwork') is-invalid @enderror"
                                           min="0"
                                           max="100"
                                           placeholder="Skala 0 - 100"
                                           value="{{ old('non_technical_scores.teamwork', $assessment->non_technical_scores['teamwork'] ?? '') }}"
                                           required>
                                    <span class="input-group-text bg-white fw-medium text-secondary">/ 100</span>
                                </div>
                            </div>
                        </div>

                        <!-- Live Non-Technical Average Indicator -->
                        <div class="alert alert-success bg-success bg-opacity-10 border-success-subtle text-success rounded-3 p-3 mt-4 mb-0 d-flex align-items-center justify-content-between">
                            <span class="small fw-semibold">
                                <i class="fa-solid fa-calculator me-1"></i> Estimasi Rata-rata Non-Teknik:
                            </span>
                            <span class="fs-5 fw-bold" id="liveNonTechAverage">
                                {{ $assessment->attitude_score ?? '0' }} / 100
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Catatan Evaluasi & Tombol Simpan -->
            <div class="premium-card p-4 shadow-sm border-0 mb-4">
                <h5 class="font-title text-dark mb-3">
                    <i class="fa-regular fa-comment-dots text-primary me-2"></i>Catatan & Evaluasi Pembimbing (Opsional)
                </h5>
                <div class="mb-3">
                    <textarea name="notes"
                              id="notes"
                              rows="4"
                              class="form-control rounded-3 @error('notes') is-invalid @enderror"
                              placeholder="Tambahkan catatan evaluasi perkembangan keahlian, sikap perilaku, masukan, atau saran perbaikan untuk siswa...">{{ old('notes', $assessment->notes ?? '') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2 border-top">
                    <span class="text-muted small">
                        <i class="fa-solid fa-circle-info text-primary me-1"></i>Pastikan seluruh nilai aspek teknik dan non-teknik sudah terisi dengan benar sebelum menyimpan.
                    </span>
                    <div class="d-flex gap-2 flex-wrap">
                        @if(isset($assessment))
                            <a href="{{ route('admin.prakerin.certificate', $student->id) }}" target="_blank" class="btn btn-outline-primary rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                                <i class="fa-solid fa-print me-2"></i>Cetak Sertifikat
                            </a>
                        @endif
                        <button type="submit" class="btn btn-gradient-success rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Penilaian
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Ringkasan / Rekapitulasi Penilaian -->
        <div class="premium-card p-4 shadow-sm border-0">
            <h5 class="font-title text-dark mb-3">
                <i class="fa-solid fa-chart-column text-primary me-2"></i>Ringkasan & Rekapitulasi Penilaian
            </h5>

            @if($assessment)
                @php
                    $avgScore = round(($assessment->skill_score + $assessment->attitude_score) / 2, 1);
                    $avgNonTeknik = $assessment->attitude_score;

                    if ($avgScore >= 90) {
                        $grade = 'A';
                        $predicate = 'Sangat Baik (Memuaskan)';
                        $badgeClass = 'bg-success text-white';
                    } elseif ($avgScore >= 80) {
                        $grade = 'B';
                        $predicate = 'Baik';
                        $badgeClass = 'bg-primary text-white';
                    } elseif ($avgScore >= 70) {
                        $grade = 'C';
                        $predicate = 'Cukup';
                        $badgeClass = 'bg-warning text-dark';
                    } else {
                        $grade = 'D';
                        $predicate = 'Kurang';
                        $badgeClass = 'bg-danger text-white';
                    }

                    $tkjTitles = [
                        'os_installation' => ['label' => 'Instalasi Sistem Operasi Dasar', 'icon' => 'fa-compact-disc text-primary'],
                        'troubleshooting' => ['label' => 'Melakukan Troubleshooting', 'icon' => 'fa-wrench text-warning'],
                        'pc_assembly' => ['label' => 'Perakitan & Perawatan PC', 'icon' => 'fa-microchip text-info'],
                        'lan_cabling' => ['label' => 'Pengkabelan & Jaringan LAN', 'icon' => 'fa-network-wired text-success'],
                        'network_config' => ['label' => 'Konfigurasi Router & Wireless', 'icon' => 'fa-wifi text-danger'],
                        'network_services' => ['label' => 'Administrasi Layanan Server/Jaringan', 'icon' => 'fa-server text-secondary'],
                    ];

                    $rplTitles = [
                        'system_design' => ['label' => 'Analisis Sistem & Desain UI/UX', 'icon' => 'fa-pen-ruler text-primary'],
                        'web_development' => ['label' => 'Pemrograman Web & Backend', 'icon' => 'fa-code text-success'],
                        'database_management' => ['label' => 'Pengelolaan Database (SQL)', 'icon' => 'fa-database text-warning'],
                        'oop_programming' => ['label' => 'Pemrograman Berorientasi Objek (OOP)', 'icon' => 'fa-cubes text-info'],
                        'testing_debugging' => ['label' => 'Testing & Debugging Program', 'icon' => 'fa-bug-slash text-danger'],
                        'git_deployment' => ['label' => 'Version Control (Git) & Hosting', 'icon' => 'fa-cloud-arrow-up text-secondary'],
                    ];

                    $dkvTitles = [
                        'vector_design' => ['label' => 'Desain Grafis Berbasis Vektor', 'icon' => 'fa-bezier-curve text-primary'],
                        'raster_editing' => ['label' => 'Pengolahan Citra Digital & Bitmap', 'icon' => 'fa-wand-magic-sparkles text-success'],
                        'typography_layout' => ['label' => 'Tipografi & Tata Letak Layout', 'icon' => 'fa-font text-warning'],
                        'branding_identity' => ['label' => 'Identitas Visual & Branding', 'icon' => 'fa-palette text-info'],
                        'digital_illustration' => ['label' => 'Ilustrasi Digital & Konten Kreatif', 'icon' => 'fa-paint-brush text-danger'],
                        'audio_video_motion' => ['label' => 'Video Editing & Final Artwork', 'icon' => 'fa-film text-secondary'],
                    ];

                    $nonTechnicalTitles = [
                        'attitude' => ['label' => 'Sikap (Attitude)', 'icon' => 'fa-heart-circle-check text-success'],
                        'diligence' => ['label' => 'Kerajinan', 'icon' => 'fa-fire text-warning'],
                        'discipline' => ['label' => 'Kedisiplinan', 'icon' => 'fa-business-time text-primary'],
                        'initiative_creativity' => ['label' => 'Inisiatif & Kreativitas', 'icon' => 'fa-lightbulb text-warning'],
                        'responsibility' => ['label' => 'Tanggung Jawab', 'icon' => 'fa-shield-halved text-info'],
                        'honesty' => ['label' => 'Kejujuran', 'icon' => 'fa-hand-holding-heart text-danger'],
                        'teamwork' => ['label' => 'Kerja Sama', 'icon' => 'fa-people-group text-success'],
                    ];

                    $isRplSaved = is_array($assessment->technical_scores) && (isset($assessment->technical_scores['system_design']) || isset($assessment->technical_scores['web_development']));
                    $isDkvSaved = is_array($assessment->technical_scores) && (isset($assessment->technical_scores['vector_design']) || isset($assessment->technical_scores['raster_editing']));
                    $isTkjSaved = is_array($assessment->technical_scores) && (isset($assessment->technical_scores['os_installation']) || isset($assessment->technical_scores['troubleshooting']));
                @endphp

                <div class="row g-3 mb-4">
                    <!-- Aspek Teknik Box -->
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-light h-100 border-primary-subtle">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="small text-muted fw-semibold">Rata-rata Aspek Teknik</span>
                                <span class="badge bg-primary-subtle text-primary small">
                                    {{ $isRplSaved ? 'Jurusan RPL' : ($isDkvSaved ? 'Jurusan DKV' : ($isTkjSaved ? 'Jurusan TKJ' : 'Keahlian')) }}
                                </span>
                            </div>
                            <div class="fs-3 fw-bold text-primary">{{ $assessment->skill_score }} <small class="fs-6 text-muted fw-normal">/ 100</small></div>
                            <div class="small text-secondary mt-1">Keahlian Teknik Kejuruan</div>
                        </div>
                    </div>

                    <!-- Aspek Non-Teknik Box -->
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-light h-100 border-success-subtle">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="small text-muted fw-semibold">Rata-rata Non-Teknik</span>
                                <span class="badge bg-success-subtle text-success small">7 Aspek Sikap</span>
                            </div>
                            <div class="fs-3 fw-bold text-success">{{ $avgNonTeknik }} <small class="fs-6 text-muted fw-normal">/ 100</small></div>
                            <div class="small text-secondary mt-1">Sikap, Disiplin & Karakter</div>
                        </div>
                    </div>

                    <!-- Nilai Akhir Box -->
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-light h-100 border-info-subtle">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="small text-muted fw-semibold">Nilai Akhir Rata-rata</span>
                                <span class="badge {{ $badgeClass }} small px-2 py-1">Predikat {{ $grade }}</span>
                            </div>
                            <div class="fs-3 fw-bold text-dark">{{ $avgScore }} <small class="fs-6 text-muted fw-normal">/ 100</small></div>
                            <div class="small text-secondary mt-1">{{ $predicate }}</div>
                        </div>
                    </div>
                </div>

                <!-- Rincian Nilai Aspek Teknik (RPL) -->
                @if($isRplSaved)
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-code text-primary me-2"></i>Rincian 6 Nilai Aspek Teknik (Rekayasa Perangkat Lunak - RPL):
                        </h6>
                        <div class="row g-2">
                            @foreach($rplTitles as $key => $item)
                                @if(isset($assessment->technical_scores[$key]))
                                    <div class="col-md-6 col-lg-4">
                                        <div class="border rounded-3 p-2 bg-white d-flex align-items-center justify-content-between shadow-xs">
                                            <div class="d-flex align-items-center text-truncate me-2">
                                                <i class="fa-solid {{ $item['icon'] }} me-2 fs-6"></i>
                                                <span class="small text-dark text-truncate">{{ $item['label'] }}</span>
                                            </div>
                                            <span class="badge bg-primary text-white px-2 py-1 fs-6 fw-bold">
                                                {{ $assessment->technical_scores[$key] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Rincian Nilai Aspek Teknik (TKJ) -->
                @if($isTkjSaved)
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-network-wired text-primary me-2"></i>Rincian 6 Nilai Aspek Teknik (Teknik Komputer & Jaringan - TKJ):
                        </h6>
                        <div class="row g-2">
                            @foreach($tkjTitles as $key => $item)
                                @if(isset($assessment->technical_scores[$key]))
                                    <div class="col-md-6 col-lg-4">
                                        <div class="border rounded-3 p-2 bg-white d-flex align-items-center justify-content-between shadow-xs">
                                            <div class="d-flex align-items-center text-truncate me-2">
                                                <i class="fa-solid {{ $item['icon'] }} me-2 fs-6"></i>
                                                <span class="small text-dark text-truncate">{{ $item['label'] }}</span>
                                            </div>
                                            <span class="badge bg-primary text-white px-2 py-1 fs-6 fw-bold">
                                                {{ $assessment->technical_scores[$key] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Rincian Nilai Aspek Teknik (DKV) -->
                @if($isDkvSaved)
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-palette text-primary me-2"></i>Rincian 6 Nilai Aspek Teknik (Desain Komunikasi Visual - DKV):
                        </h6>
                        <div class="row g-2">
                            @foreach($dkvTitles as $key => $item)
                                @if(isset($assessment->technical_scores[$key]))
                                    <div class="col-md-6 col-lg-4">
                                        <div class="border rounded-3 p-2 bg-white d-flex align-items-center justify-content-between shadow-xs">
                                            <div class="d-flex align-items-center text-truncate me-2">
                                                <i class="fa-solid {{ $item['icon'] }} me-2 fs-6"></i>
                                                <span class="small text-dark text-truncate">{{ $item['label'] }}</span>
                                            </div>
                                            <span class="badge bg-primary text-white px-2 py-1 fs-6 fw-bold">
                                                {{ $assessment->technical_scores[$key] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Rincian 7 Nilai Aspek Non-Teknik -->
                @if(is_array($assessment->non_technical_scores) && count($assessment->non_technical_scores) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="fa-solid fa-list-check text-success me-2"></i>Rincian 7 Nilai Aspek Non-Teknik (Sikap & Perilaku):
                        </h6>
                        <div class="row g-2">
                            @foreach($nonTechnicalTitles as $key => $item)
                                @if(isset($assessment->non_technical_scores[$key]))
                                    <div class="col-md-6 col-lg-4">
                                        <div class="border rounded-3 p-2 bg-white d-flex align-items-center justify-content-between shadow-xs">
                                            <div class="d-flex align-items-center text-truncate me-2">
                                                <i class="fa-solid {{ $item['icon'] }} me-2 fs-6"></i>
                                                <span class="small text-dark text-truncate">{{ $item['label'] }}</span>
                                            </div>
                                            <span class="badge bg-success text-white px-2 py-1 fs-6 fw-bold">
                                                {{ $assessment->non_technical_scores[$key] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="alert alert-info rounded-3 border-0 shadow-sm mb-0">
                    <div class="fw-semibold text-dark"><i class="fa-solid fa-note-sticky me-1 text-primary"></i>Catatan Pembimbing:</div>
                    <div class="small text-secondary mt-1">{{ $assessment->notes ?: 'Belum ada catatan tambahan.' }}</div>
                </div>
            @else
                <div class="text-center py-5 text-secondary">
                    <i class="fa-solid fa-file-pen display-6 text-muted mb-3 d-block"></i>
                    <p class="mb-0">Belum ada penilaian yang dibuat untuk siswa ini. Silakan isi form di atas dan simpan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Live Calculation & Department Switcher Script -->
<script>
let currentDept = '{{ $detectedDept }}';

function switchDept(dept) {
    currentDept = dept;

    const sectionTKJ = document.getElementById('sectionTKJ');
    const sectionRPL = document.getElementById('sectionRPL');
    const sectionDKV = document.getElementById('sectionDKV');
    const btnTKJ = document.getElementById('btnTabTKJ');
    const btnRPL = document.getElementById('btnTabRPL');
    const btnDKV = document.getElementById('btnTabDKV');
    const labelDept = document.getElementById('activeDeptLabel');
    const badgeDept = document.getElementById('badgeDeptActive');

    const inputsTKJ = document.querySelectorAll('.tech-score-input-tkj');
    const inputsRPL = document.querySelectorAll('.tech-score-input-rpl');
    const inputsDKV = document.querySelectorAll('.tech-score-input-dkv');

    [btnTKJ, btnRPL, btnDKV].forEach(btn => {
        if (btn) {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        }
    });

    if (dept === 'rpl') {
        if (sectionTKJ) sectionTKJ.style.display = 'none';
        if (sectionDKV) sectionDKV.style.display = 'none';
        if (sectionRPL) sectionRPL.style.display = 'block';

        if (btnRPL) {
            btnRPL.classList.add('btn-primary');
            btnRPL.classList.remove('btn-outline-primary');
        }

        if (labelDept) labelDept.textContent = 'Rekayasa Perangkat Lunak (RPL)';
        if (badgeDept) badgeDept.textContent = 'RPL';

        inputsRPL.forEach(inp => { inp.disabled = false; inp.required = true; });
        inputsTKJ.forEach(inp => { inp.disabled = true; inp.required = false; });
        inputsDKV.forEach(inp => { inp.disabled = true; inp.required = false; });
    } else if (dept === 'dkv') {
        if (sectionTKJ) sectionTKJ.style.display = 'none';
        if (sectionRPL) sectionRPL.style.display = 'none';
        if (sectionDKV) sectionDKV.style.display = 'block';

        if (btnDKV) {
            btnDKV.classList.add('btn-primary');
            btnDKV.classList.remove('btn-outline-primary');
        }

        if (labelDept) labelDept.textContent = 'Desain Komunikasi Visual (DKV)';
        if (badgeDept) badgeDept.textContent = 'DKV';

        inputsDKV.forEach(inp => { inp.disabled = false; inp.required = true; });
        inputsTKJ.forEach(inp => { inp.disabled = true; inp.required = false; });
        inputsRPL.forEach(inp => { inp.disabled = true; inp.required = false; });
    } else {
        if (sectionRPL) sectionRPL.style.display = 'none';
        if (sectionDKV) sectionDKV.style.display = 'none';
        if (sectionTKJ) sectionTKJ.style.display = 'block';

        if (btnTKJ) {
            btnTKJ.classList.add('btn-primary');
            btnTKJ.classList.remove('btn-outline-primary');
        }

        if (labelDept) labelDept.textContent = 'Teknik Komputer & Jaringan (TKJ)';
        if (badgeDept) badgeDept.textContent = 'TKJ';

        inputsTKJ.forEach(inp => { inp.disabled = false; inp.required = true; });
        inputsRPL.forEach(inp => { inp.disabled = true; inp.required = false; });
        inputsDKV.forEach(inp => { inp.disabled = true; inp.required = false; });
    }

    updateTechAverage();
}

function updateTechAverage() {
    const liveTechAverage = document.getElementById('liveTechAverage');
    let selector = '.tech-score-input-tkj';
    if (currentDept === 'rpl') {
        selector = '.tech-score-input-rpl';
    } else if (currentDept === 'dkv') {
        selector = '.tech-score-input-dkv';
    }
    const activeInputs = document.querySelectorAll(selector);

    let total = 0;
    let count = 0;
    activeInputs.forEach(input => {
        const val = parseFloat(input.value);
        if (!isNaN(val) && val >= 0 && val <= 100) {
            total += val;
            count++;
        }
    });

    if (count > 0) {
        const avg = (total / count).toFixed(1);
        liveTechAverage.textContent = avg + ' / 100';
    } else {
        liveTechAverage.textContent = '0 / 100';
    }
}

function updateNonTechAverage() {
    const nonTechInputs = document.querySelectorAll('.non-tech-score-input');
    const liveNonTechAverage = document.getElementById('liveNonTechAverage');

    let total = 0;
    let count = 0;
    nonTechInputs.forEach(input => {
        const val = parseFloat(input.value);
        if (!isNaN(val) && val >= 0 && val <= 100) {
            total += val;
            count++;
        }
    });

    if (count > 0) {
        const avg = (total / count).toFixed(1);
        liveNonTechAverage.textContent = avg + ' / 100';
    } else {
        liveNonTechAverage.textContent = '0 / 100';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Add input listeners for real-time calculation
    document.querySelectorAll('.tech-score-input-tkj, .tech-score-input-rpl, .tech-score-input-dkv').forEach(input => {
        input.addEventListener('input', updateTechAverage);
    });

    document.querySelectorAll('.non-tech-score-input').forEach(input => {
        input.addEventListener('input', updateNonTechAverage);
    });

    // Ensure correct initial disabled state
    switchDept(currentDept);
    updateNonTechAverage();
});
</script>
@endsection
