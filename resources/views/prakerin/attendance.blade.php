@extends('layouts.app')

@section('title', 'Absensi Prakerin')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="premium-card p-4 h-100 shadow-sm">
            <h4 class="font-title text-dark mb-3"><i class="fa-solid fa-clipboard-user text-primary me-2"></i>Absensi Prakerin</h4>
            <p class="text-muted small mb-4">Isi kehadiran harian siswa prakerin sesuai dengan kondisi hari ini.</p>

            <form action="{{ route('prakerin.attendance.store') }}" method="POST">
                @csrf
                <div class="alert alert-light border rounded-3 p-3 mb-3 d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-regular fa-calendar-check fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Tanggal Absensi</span>
                        <span class="fw-bold text-dark fs-6">{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-medium text-secondary small">Status Kehadiran</label>
                    <select name="status" id="status" class="form-select rounded-3" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>Hadir</option>
                        <option value="sick" {{ old('status') === 'sick' || old('status') === 'late' ? 'selected' : '' }}>Sakit</option>
                        <option value="permission" {{ old('status') === 'permission' ? 'selected' : '' }}>Izin</option>
                        <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label fw-medium text-secondary small">Catatan</label>
                    <textarea name="note" id="note" rows="4" class="form-control rounded-3" placeholder="Catatan singkat (opsional)">{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="btn btn-gradient-primary rounded-3 w-100">
                    <i class="fa-solid fa-save me-2"></i>Simpan Absensi
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="premium-card p-4 shadow-sm">
            <h5 class="font-title text-dark mb-3"><i class="fa-solid fa-list-check text-success me-2"></i>Riwayat Absensi</h5>

            @if($attendances->isEmpty())
                <div class="text-center py-5 text-secondary">
                    <i class="fa-solid fa-calendar-xmark display-6 text-muted mb-3 d-block"></i>
                    <p class="mb-0">Belum ada data absensi yang dicatat.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 custom-table">
                        <thead>
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y, H:i') }} WIB</td>
                                    <td>
                                        @if($attendance->status === 'present')
                                            <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Hadir</span>
                                        @elseif($attendance->status === 'late' || $attendance->status === 'sick')
                                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-notes-medical me-1"></i>Sakit</span>
                                        @elseif($attendance->status === 'permission')
                                            <span class="badge bg-info text-white"><i class="fa-solid fa-paper-plane me-1"></i>Izin</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Tidak Hadir</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->note ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
