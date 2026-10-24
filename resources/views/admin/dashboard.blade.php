@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Header and Quick Stats -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="font-title text-dark mb-1">Dashboard Administrator</h2>
        <p class="text-secondary mb-0">Kelola pendaftaran, validasi data, dan jurnal kegiatan peserta Prakerin.</p>
    </div>
    <div>
        <a href="{{ route('admin.prakerin.create') }}" class="btn btn-gradient-primary rounded-pill shadow-sm">
            <i class="fa-solid fa-user-plus me-2"></i>Tambah Peserta Baru
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <div class="col-6 col-lg-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Total Peserta</h6>
                    <h2 class="font-title mb-0">{{ $stats['total'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Menunggu Validasi</h6>
                    <h2 class="font-title mb-0">{{ $stats['pending'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Disetujui (Aktif)</h6>
                    <h2 class="font-title mb-0">{{ $stats['approved'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Ditolak</h6>
                    <h2 class="font-title mb-0">{{ $stats['rejected'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search, Filter & Student Table Card -->
<div class="premium-card p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h4 class="font-title mb-0 text-dark">Data Peserta Prakerin</h4>

        <!-- Search and Filter Form -->
        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center col-12 col-md-auto">
            <div class="input-group" style="max-width: 250px;">
                <span class="input-group-text bg-white border-end-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 rounded-end-3" placeholder="Cari nama, sekolah..." value="{{ request('search') }}">
            </div>

            <select name="status" class="form-select rounded-3" style="max-width: 160px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3" title="Clear Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table content -->
    <div class="table-responsive">
        <table class="table custom-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 44%;">Informasi Peserta & Sekolah</th>
                    <th style="width: 22%;">Periode Magang</th>
                    <th style="width: 14%;" class="text-center">Status</th>
                    <th style="width: 15%;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>
                            <span class="fw-bold text-secondary">#{{ $student->id }}</span>
                        </td>

                        <!-- Student & School Profile -->
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary flex-shrink-0" style="width: 42px; height: 42px; font-size: 0.9rem;">
                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $student->name }}</div>
                                    <div class="small text-muted mb-1"><i class="fa-solid fa-envelope me-1"></i>{{ $student->email }}</div>
                                    @if($student->prakerinProfile)
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            <span class="badge bg-light text-dark border font-normal"><i class="fa-solid fa-school me-1 text-primary"></i>{{ $student->prakerinProfile->school }}</span>
                                            <span class="badge bg-light text-dark border font-normal"><i class="fa-solid fa-graduation-cap me-1 text-info"></i>{{ $student->prakerinProfile->department }}</span>
                                            <span class="badge bg-light text-secondary border font-normal">NISN: {{ $student->prakerinProfile->nisn }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Belum Mengisi Profil</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Date range -->
                        <td>
                            @if($student->prakerinProfile)
                                <div class="small text-dark">
                                    <div><i class="fa-regular fa-calendar-days text-primary me-1"></i> <b>Mulai:</b> {{ \Carbon\Carbon::parse($student->prakerinProfile->start_date)->translatedFormat('d M Y') }}</div>
                                    <div class="mt-1"><i class="fa-regular fa-calendar-check text-success me-1"></i> <b>Selesai:</b> {{ \Carbon\Carbon::parse($student->prakerinProfile->end_date)->translatedFormat('d M Y') }}</div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <!-- Status & Validation -->
                        <td class="text-center">
                            @if($student->prakerinProfile)
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <div>
                                        @if($student->prakerinProfile->status === 'pending')
                                            <span class="badge-pending"><i class="fa-regular fa-clock me-1"></i>Menunggu</span>
                                        @elseif($student->prakerinProfile->status === 'approved')
                                            <span class="badge-approved"><i class="fa-regular fa-circle-check me-1"></i>Disetujui</span>
                                        @else
                                            <span class="badge-rejected"><i class="fa-regular fa-circle-xmark me-1"></i>Ditolak</span>
                                        @endif
                                    </div>

                                    <div class="mt-1 d-flex gap-1 justify-content-center">
                                        @if($student->prakerinProfile->status !== 'approved')
                                            <form action="{{ route('admin.prakerin.validate', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0.5" style="font-size: 0.75rem;" title="Setujui/Validasi">
                                                    <i class="fa-solid fa-check me-1"></i>Setujui
                                                </button>
                                            </form>
                                        @endif

                                        @if($student->prakerinProfile->status !== 'rejected')
                                            <form action="{{ route('admin.prakerin.validate', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-2 py-0.5" style="font-size: 0.75rem;" title="Tolak">
                                                    <i class="fa-solid fa-xmark me-1"></i>Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </td>

                        <!-- Aksi Cepat / Navigasi -->
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <a href="{{ route('admin.prakerin.activities', $student->id) }}" 
                                   class="btn btn-sm btn-light border text-primary rounded-3 px-2 py-1" 
                                   title="Lihat Jurnal Kegiatan">
                                    <i class="fa-solid fa-book-open"></i>
                                </a>
                                <a href="{{ route('admin.prakerin.assessment', $student->id) }}" 
                                   class="btn btn-sm btn-light border text-warning rounded-3 px-2 py-1" 
                                   title="Penilaian Prakerin">
                                    <i class="fa-solid fa-star"></i>
                                </a>
                                <a href="{{ route('admin.attendances', ['user_id' => $student->id]) }}" 
                                   class="btn btn-sm btn-light border text-info rounded-3 px-2 py-1" 
                                   title="Lihat Riwayat Absensi">
                                    <i class="fa-solid fa-clipboard-user"></i>
                                </a>
                                <a href="{{ route('admin.prakerin.edit', $student->id) }}" 
                                   class="btn btn-sm btn-light border text-secondary rounded-3 px-2 py-1" 
                                   title="Ubah Profil">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.prakerin.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini? Seluruh jurnal kegiatan juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-light border text-danger rounded-3 px-2 py-1" 
                                            title="Hapus Peserta">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <i class="fa-regular fa-folder-open display-6 text-muted mb-3 d-block"></i>
                            Tidak ada data peserta magang yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Navigasi halaman daftar peserta">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $students->previousPageUrl() ?? '#' }}" aria-label="Sebelumnya">&laquo;</a>
                    </li>

                    @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $students->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $students->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $students->nextPageUrl() ?? '#' }}" aria-label="Berikutnya">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection
