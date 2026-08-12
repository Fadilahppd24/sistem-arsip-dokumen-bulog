@php
    $user = auth()->user();
@endphp

<header class="topbar d-flex align-items-center justify-content-between">

    {{-- =====================================================
        LEFT
    ====================================================== --}}
    <div>

        <button
            class="btn btn-sm btn-light d-lg-none"
            type="button"
        >
            <i class="bi bi-list fs-5"></i>
        </button>

    </div>


    {{-- =====================================================
        RIGHT
    ====================================================== --}}
    <div class="d-flex align-items-center gap-3">


        {{-- =================================================
            TANGGAL
        ================================================== --}}
        <div class="date-box">

            <i class="bi bi-calendar-event"></i>

            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}

        </div>


        {{-- =================================================
            DARK MODE
        ================================================== --}}
        <button
            class="btn btn-sm btn-light"
            id="themeToggle"
            title="Ganti Tema"
            type="button"
        >

            <i
                class="bi bi-moon-fill"
                id="themeIcon"
            ></i>

        </button>


        {{-- =================================================
            PROFILE
        ================================================== --}}
        <div class="dropdown">


            {{-- PROFILE BUTTON --}}
            <a
                href="#"
                class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle user-dropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >


                {{-- AVATAR --}}
                <div class="navbar-avatar-wrapper">

                    @if ($user->profile_photo_path)

                        <img
                            src="{{ asset('storage/' . $user->profile_photo_path) }}"
                            alt="Foto Profil {{ $user->name }}"
                            class="navbar-avatar"
                        >

                    @else

                        <div class="avatar-circle bg-bulog-navy">

                            {{ strtoupper(substr($user->name, 0, 1)) }}

                        </div>

                    @endif

                </div>


                {{-- NAMA + ROLE --}}
                <div class="d-none d-md-block text-start">

                    <div class="small fw-semibold lh-1">

                        {{ $user->name }}

                    </div>


                    <div
                        class="small text-muted"
                        style="font-size:.72rem;"
                    >

                        {{ $user->isAdmin() ? 'Administrator' : 'User' }}

                    </div>

                </div>

            </a>



            {{-- =================================================
                DROPDOWN PROFILE
            ================================================== --}}
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">


                {{-- HEADER PROFILE --}}
                <li>

                    <div class="px-3 py-2">

                        <div class="d-flex align-items-center gap-2">


                            @if ($user->profile_photo_path)

                                <img
                                    src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                    alt="Foto Profil"
                                    class="profile-dropdown-avatar"
                                >

                            @else

                                <div class="profile-dropdown-avatar avatar-circle bg-bulog-navy">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>

                            @endif


                            <div>

                                <div class="fw-semibold">

                                    {{ $user->name }}

                                </div>

                                <div
                                    class="text-muted"
                                    style="font-size:.75rem;"
                                >

                                    {{ $user->isAdmin() ? 'Administrator' : 'User' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>



                {{-- =================================================
                    GANTI FOTO PROFIL
                ================================================== --}}
                <li>

                    <form
                        action="{{ route('profile.photo.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="formGantiFoto"
                    >

                        @csrf

                        <input
                            type="file"
                            name="profile_photo"
                            id="profilePhotoInput"
                            accept="image/jpeg,image/png,image/jpg"
                            class="d-none"
                        >


                        <button
                            type="button"
                            class="dropdown-item"
                            id="btnGantiFoto"
                        >

                            <i class="bi bi-camera me-2"></i>

                            Ganti Foto Profil

                        </button>

                    </form>

                </li>



                {{-- =================================================
                    HAPUS FOTO PROFIL
                    HANYA MUNCUL JIKA ADA FOTO
                ================================================== --}}
                @if ($user->profile_photo_path)

                    <li>

                        <form
                            action="{{ route('profile.photo.delete') }}"
                            method="POST"
                            id="formHapusFoto"
                        >

                            @csrf

                            @method('DELETE')


                            <button
                                type="button"
                                class="dropdown-item text-danger"
                                id="btnHapusFoto"
                            >

                                <i class="bi bi-trash3 me-2"></i>

                                Hapus Foto Profil

                            </button>

                        </form>

                    </li>

                @endif



                {{-- =================================================
                    LOGOUT
                ================================================== --}}
                <li>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            class="dropdown-item text-danger"
                            type="submit"
                        >

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Keluar

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</header>

{{-- MODAL KONFIRMASI HAPUS FOTO --}}
<div class="modal fade" id="modalHapusFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-hapus-foto">

            <div class="modal-body text-center p-4">

                {{-- ICON --}}
                <div class="hapus-foto-icon mx-auto mb-3">
                    <i class="bi bi-trash3"></i>
                </div>

                {{-- JUDUL --}}
                <h5 class="fw-bold mb-2">
                    Hapus Foto Profil?
                </h5>

                {{-- KETERANGAN --}}
                <p class="text-muted mb-4">
                    Foto profil kamu akan dihapus dan
                    avatar akan kembali menggunakan huruf awal nama.
                </p>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-center gap-2">

                    <button
                        type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger px-4"
                        id="btnKonfirmasiHapus"
                    >
                        <i class="bi bi-trash3 me-1"></i>
                        Ya, Hapus
                    </button>

                </div>

            </div>

        </div>
    </div>
</div>

{{-- =========================================================
    STYLE PROFILE
========================================================= --}}
<style>

/* =========================================================
   MODAL HAPUS FOTO PROFIL
========================================================= */

.modal-hapus-foto {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(0, 0, 0, .20);
}

.hapus-foto-icon {
    width: 70px;
    height: 70px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #fff1f2;
    color: #dc3545;

    font-size: 30px;
}

.modal-hapus-foto h5 {
    color: #1e293b;
}

.modal-hapus-foto p {
    font-size: 14px;
    line-height: 1.6;
}

.modal-hapus-foto .btn {
    border-radius: 9px;
    font-weight: 600;
}

.modal-hapus-foto .btn-danger {
    background: #dc3545;
    border-color: #dc3545;
}

.modal-hapus-foto .btn-danger:hover {
    background: #bb2d3b;
    border-color: #bb2d3b;
}



.navbar-avatar-wrapper {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
}


.navbar-avatar {
    width: 42px;
    height: 42px;

    object-fit: cover;

    border-radius: 50%;

    display: block;

    border: 2px solid #ffffff;

    box-shadow:
        0 3px 10px rgba(0, 0, 0, .15);
}


/* =========================================================
   DEFAULT HURUF
========================================================= */

.navbar-avatar-wrapper .avatar-circle {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    color: white;

    font-size: 16px;

    font-weight: 700;

    border: 2px solid white;

    box-shadow:
        0 3px 10px rgba(0, 0, 0, .15);

}


/* =========================================================
   DROPDOWN AVATAR
========================================================= */

.profile-dropdown-avatar {

    width: 42px;
    height: 42px;

    object-fit: cover;

    border-radius: 50%;

    flex-shrink: 0;

    border: 2px solid #fff;

}


.profile-dropdown-avatar.avatar-circle {

    display: flex;

    align-items: center;
    justify-content: center;

    color: white;

    font-weight: 700;

}


/* =========================================================
   DROPDOWN
========================================================= */

.dropdown-menu {

    min-width: 235px;

    border-radius: 12px;

    padding: 7px;

}


.dropdown-item {

    border-radius: 8px;

    padding: 9px 10px;

    transition:
        background-color .15s ease,
        color .15s ease;

}


.dropdown-item:hover {

    background: #f1f5f9;

}


.dropdown-item.text-danger:hover {

    background: #fff1f2;

    color: #dc3545 !important;

}


.user-dropdown::after {

    margin-left: 2px;

}

</style>



{{-- =========================================================
    JAVASCRIPT PROFILE
========================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       GANTI FOTO PROFIL
    ====================================================== */

    const btnGantiFoto =
        document.getElementById('btnGantiFoto');

    const profilePhotoInput =
        document.getElementById('profilePhotoInput');

    const formGantiFoto =
        document.getElementById('formGantiFoto');


    if (
        btnGantiFoto &&
        profilePhotoInput &&
        formGantiFoto
    ) {

        btnGantiFoto.addEventListener('click', function () {

            profilePhotoInput.click();

        });


        profilePhotoInput.addEventListener('change', function () {

            if (this.files && this.files.length > 0) {

                formGantiFoto.submit();

            }

        });

    }



/* =====================================================
   HAPUS FOTO PROFIL
====================================================== */

const btnHapusFoto =
    document.getElementById('btnHapusFoto');

const formHapusFoto =
    document.getElementById('formHapusFoto');

const modalHapusFoto =
    document.getElementById('modalHapusFoto');

const btnKonfirmasiHapus =
    document.getElementById('btnKonfirmasiHapus');


if (
    btnHapusFoto &&
    formHapusFoto &&
    modalHapusFoto
) {

    // Buka modal konfirmasi
    btnHapusFoto.addEventListener('click', function () {

        const modal = new bootstrap.Modal(modalHapusFoto);

        modal.show();

    });


    // Konfirmasi hapus
    if (btnKonfirmasiHapus) {

        btnKonfirmasiHapus.addEventListener('click', function () {

            formHapusFoto.submit();

        });

    }

}

    }

);

</script>