@extends('layouts.app')

@section('title', 'Backup Database')

@section('content')

<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                Beranda
            </a>
        </li>
        <li class="breadcrumb-item active">
            Backup Database
        </li>
    </ol>
</nav>


<div class="card-panel p-4">

    <div class="text-center">

        <i class="bi bi-database-fill-down"
           style="font-size:60px;color:#123b7a;">
        </i>


        <h3 class="fw-bold mt-3">
            Backup Database
        </h3>


        <p class="text-muted">
            Lakukan backup database sistem arsip dokumen.
            File backup akan tersimpan dalam format SQL.
        </p>


        <a href="{{ route('backup.database') }}"
           class="btn btn-bulog mt-3">

            <i class="bi bi-download me-2"></i>
            Backup & Download Database

        </a>


    </div>

</div>

@endsection