<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sistem Arsip Dokumen BULOG</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div class="d-flex">

    @include('partials.sidebar')

    <div class="flex-grow-1" style="min-width: 0;">
        @include('partials.navbar')

        <main class="p-4">

    @yield('content')

</main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

document.addEventListener('DOMContentLoaded', function () {

    if (sessionStorage.getItem('welcomePlayed')) {
        return;
    }

    sessionStorage.setItem('welcomePlayed', 'true');

    const audio = new Audio("{{ asset('audio/welcome.mp3') }}");
    audio.volume = 1;

    setTimeout(() => {
        audio.play().catch(err => {
            console.warn('Autoplay diblokir browser:', err);
        });
    }, 1000);

});

</script>

</body>
</html>