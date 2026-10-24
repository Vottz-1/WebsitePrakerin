@extends('layouts.app')

@section('title', 'Data Absensi Peserta')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat 1: Total Absensi -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small d-block mb-1">Total Catatan Absensi</span>
                <h3 class="font-title mb-0 text-dark">{{ $stats['total'] }}</h3>
            </div>
            <div class="stat-card-icon text-primary bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="fa-solid fa-clipboard-list fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Stat 2: Hadir -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small d-block mb-1">Hadir</span>
                <h3 class="font-title mb-0 text-success">{{ $stats['present'] }}</h3>
            </div>
            <div class="stat-card-icon text-success bg-success bg-opacity-10 rounded-circle p-3">
                <i class="fa-solid fa-user-check fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Stat 3: Sakit -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small d-block mb-1">Sakit</span>
                <h3 class="font-title mb-0 text-warning">{{ $stats['sick'] }}</h3>
            </div>
            <div class="stat-card-icon text-warning bg-warning bg-opacity-10 rounded-circle p-3">
                <i class="fa-solid fa-user-clock fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Stat 4: Izin -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small d-block mb-1">Izin</span>
                <h3 class="font-title mb-0 text-info">{{ $stats['permission'] }}</h3>
            </div>
            <div class="stat-card-icon text-info bg-info bg-opacity-10 rounded-circle p-3">
                <i class="fa-solid fa-envelope-open-text fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Stat 5: Tidak Hadir -->
    <div class="col-md-3 col-sm-6">
        <div class="stat-card p-3 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small d-block mb-1">Tidak Hadir (Alpha)</span>
                <h3 class="font-title mb-0 text-danger">{{ $stats['absent'] }}</h3>
            </div>
            <div class="stat-card-icon text-danger bg-danger bg-opacity-10 rounded-circle p-3">
                <i class="fa-solid fa-user-xmark fs-4"></i>
            </div>
        </div>
    </div>
</div>

<!-- Attendance List Card -->
<div class="premium-card p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="font-title mb-1 text-dark"><i class="fa-solid fa-clipboard-user text-primary me-2"></i>Rekap Data Absensi Peserta</h4>
            <p class="text-muted small mb-0">Pantau dan kelola kehadiran harian peserta prakerin.</p>
        </div>

        <!-- Back to Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="fa-solid fa-arrow-left me-1"></i> Dashboard Admin
        </a>
    </div>

    <!-- Search & Filter Form -->
    <form action="{{ route('admin.attendances') }}" method="GET" class="row g-2 mb-4 align-items-center">
        <!-- Search input -->
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 rounded-end-3" placeholder="Cari nama, email, sekolah..." value="{{ request('search') }}">
            </div>
        </div>

        <!-- Filter Student -->
        <div class="col-md-3">
            <select name="user_id" class="form-select rounded-3" onchange="this.form.submit()">
                <option value="">-- Semua Peserta --</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}" {{ request('user_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->name }} ({{ $s->prakerinProfile->school ?? 'No School' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Status -->
        <div class="col-md-2">
            <select name="status" class="form-select rounded-3" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Hadir</option>
                <option value="sick" {{ request('status') == 'sick' ? 'selected' : '' }}>Sakit</option>
                <option value="permission" {{ request('status') == 'permission' ? 'selected' : '' }}>Izin</option>
                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
            </select>
        </div>

        <!-- Filter Date -->
        <div class="col-md-2">
            <input type="date" name="date" class="form-control rounded-3" value="{{ request('date') }}" onchange="this.form.submit()">
        </div>

        <!-- Reset Button -->
        <div class="col-md-2">
            @if(request('search') || request('user_id') || request('status') || request('date'))
                <a href="{{ route('admin.attendances') }}" class="btn btn-outline-secondary rounded-3 w-100" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                </a>
            @else
                <button type="submit" class="btn btn-primary rounded-3 w-100">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
            @endif
        </div>
    </form>

    <!-- Table content -->
    <div class="table-responsive">
        <table class="table custom-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 40%;">Peserta & Sekolah</th>
                    <th style="width: 20%;">Tanggal Absensi</th>
                    <th style="width: 15%;" class="text-center">Status Kehadiran</th>
                    <th style="width: 20%;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr>
                        <td>
                            <span class="fw-bold text-secondary">#{{ $att->id }}</span>
                        </td>

                        <!-- Student Profile -->
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary flex-shrink-0" style="width: 40px; height: 40px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($att->user->name ?? 'P', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $att->user->name ?? 'Siswa Dihapus' }}</div>
                                    <div class="small text-muted">
                                        <i class="fa-solid fa-envelope me-1"></i>{{ $att->user->email ?? '-' }}
                                        @if(isset($att->user->prakerinProfile->school))
                                            <span class="badge bg-light text-dark border ms-1"><i class="fa-solid fa-school me-1 text-primary"></i>{{ $att->user->prakerinProfile->school }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Date -->
                        <td>
                            <div class="fw-semibold text-dark">
                                <i class="fa-regular fa-clock text-primary me-1"></i>
                                {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y - H:i') }} WIB
                            </div>
                            <small class="text-muted">Dicatat: {{ \Carbon\Carbon::parse($att->created_at)->diffForHumans() }}</small>
                        </td>

                        <!-- Status badge -->
                        <td class="text-center">
                            @if($att->status === 'present')
                                <span class="badge bg-success text-white border border-success px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-circle-check me-1"></i>Hadir
                                </span>
                            @elseif($att->status === 'sick' || $att->status === 'late')
                                <span class="badge bg-warning text-dark border border-warning px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-user-clock me-1"></i>Sakit
                                </span>
                            @elseif($att->status === 'permission')
                                <span class="badge bg-info text-white border border-info px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-envelope-open-text me-1"></i>Izin
                                </span>
                            @else
                                <span class="badge bg-danger text-white border border-danger px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-circle-xmark me-1"></i>Tidak Hadir
                                </span>
                            @endif
                        </td>

                        <!-- Note -->
                        <td>
                            @if($att->note)
                                <span class="text-dark small"><i class="fa-solid fa-comment-dots me-1 text-secondary"></i>{{ $att->note }}</span>
                            @else
                                <span class="text-muted small"><em>Tidak ada catatan</em></span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <i class="fa-regular fa-folder-open display-6 text-muted mb-3 d-block"></i>
                            Tidak ada data absensi yang ditemukan sesuai filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($attendances->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $attendances->links() }}
        </div>
    @endif
</div>
@endsection
