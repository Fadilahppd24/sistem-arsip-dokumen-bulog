<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sistem Arsip Dokumen BULOG</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/air-datepicker@3.6.0/air-datepicker.css"
    >

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

<div class="d-flex">

    @include('partials.sidebar')

    <div class="flex-grow-1" style="min-width: 0;">

        @include('partials.navbar')

        <main class="p-4">

            {{-- =====================================================
                 TOMBOL KEMBALI GLOBAL
                 Tidak mengubah layout halaman karena tombol dibuat
                 fixed dan hanya menggunakan history browser.
            ====================================================== --}}
            <button
                type="button"
                id="globalBackButton"
                class="global-back-button"
                onclick="kembaliKeHalamanSebelumnya()"
                title="Kembali ke halaman sebelumnya"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </button>

            @yield('content')

        </main>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* =========================================================
   TOMBOL KEMBALI GLOBAL
   Hanya menambahkan tombol navigasi, tanpa mengubah layout
   atau fungsi halaman yang sudah ada.
========================================================= */

.global-back-button {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    height: 38px;
    padding: 0 14px;

    margin-bottom: 14px;

    border: 1px solid #dbe4ef;
    border-radius: 9px;

    background: #ffffff;
    color: #475569;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    box-shadow: 0 2px 8px rgba(15, 23, 42, .04);

    transition:
        background .2s ease,
        border-color .2s ease,
        color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.global-back-button i {
    font-size: 15px;
}

.global-back-button:hover {
    background: #f8fafc;
    border-color: #b9c9dd;
    color: #1769e8;
    transform: translateX(-1px);
    box-shadow: 0 4px 12px rgba(15, 23, 42, .07);
}

.global-back-button:active {
    transform: translateX(0);
}

body.dark-mode .global-back-button {
    background: #202c3e;
    border-color: #46566d;
    color: #dbe5f2;
}

body.dark-mode .global-back-button:hover {
    background: #2b3b52;
    border-color: #60718a;
    color: #ffffff;
}

@media (max-width: 576px) {
    .global-back-button {
        height: 36px;
        padding: 0 12px;
        font-size: 12px;
        margin-bottom: 12px;
    }
}
</style>

<script>
/* =========================================================
   TOMBOL KEMBALI GLOBAL
========================================================= */

function kembaliKeHalamanSebelumnya() {

    if (window.history.length > 1) {
        window.history.back();
        return;
    }

    // Fallback jika tidak ada riwayat halaman sebelumnya.
    window.location.href = "{{ route('dashboard') }}";
}
</script>





<script>
document.addEventListener('DOMContentLoaded', function () {

    const body = document.body;
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    if (localStorage.getItem('theme') === 'dark') {

        body.classList.add('dark-mode');

        icon.classList.remove('bi-moon-fill');
        icon.classList.add('bi-sun-fill');

    }

    toggle.addEventListener('click', function () {

        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {

            localStorage.setItem('theme', 'dark');

            icon.classList.remove('bi-moon-fill');
            icon.classList.add('bi-sun-fill');

        } else {

            localStorage.setItem('theme', 'light');

            icon.classList.remove('bi-sun-fill');
            icon.classList.add('bi-moon-fill');

        }

    });

});
</script>


<script>
@if(session('play_welcome_audio'))

document.addEventListener('DOMContentLoaded', function () {

    const audio = new Audio("{{ asset('audio/welcome.mp3') }}");

    audio.volume = 1;

    setTimeout(() => {

        audio.play().catch(err => {

            console.warn('Autoplay diblokir browser:', err);

        });

    }, 1000);

});

@endif
</script>


<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.6.0/air-datepicker.js"></script>

@stack('scripts')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

@if(session('success'))

Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: "{{ session('success') }}",
    timer: 3000,
    showConfirmButton: false
});

@endif


@if(session('error'))

Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: "{{ session('error') }}"
});

@endif

</script>

</body>
</html>