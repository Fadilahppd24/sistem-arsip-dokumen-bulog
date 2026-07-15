@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')

<div class="card-panel p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="bi bi-clock-history me-2"></i>
                Riwayat Aktivitas
            </h4>
            <p class="text-muted mb-0">
                Daftar aktivitas pengguna dalam sistem
            </p>
        </div>
    </div>


    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Modul</th>
                    <th>Detail Aktivitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($logs as $log)

                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $log->user->name ?? 'System' }}
                        </div>

                        @if($log->user)
                            <small class="text-muted">
                                {{ $log->user->email }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @php
                            $badge = match($log->aktivitas) {
                                'Upload Dokumen' => 'success',
                                'Edit Dokumen' => 'warning',
                                'Hapus Dokumen' => 'danger',
                                'Download Dokumen' => 'primary',
                                'Backup Database' => 'dark',
                                default => 'secondary'
                            };
                        @endphp

                        <span class="badge bg-{{ $badge }}">
                            {{ $log->aktivitas }}
                        </span>
                    </td>

                    <td>
                        {{ $log->modul }}
                    </td>

                    <td>
                        {{ $log->keterangan }}
                    </td>

                    <td>
                        {{ $log->created_at->format('d M Y, H:i') }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada aktivitas.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="mt-3">
        {{ $logs->links() }}
    </div>

</div>

@endsection