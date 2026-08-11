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


{{-- =========================================================
     STYLE PROFILE
========================================================= --}}

<style>

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


/* DEFAULT HURUF */

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


/* DROPDOWN */

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


.dropdown-menu {

    min-width: 235px;

    border-radius: 12px;

    padding: 7px;

}


.dropdown-item {

    border-radius: 8px;

    padding: 9px 10px;

}


.dropdown-item:hover {

    background: #f1f5f9;

}


.user-dropdown::after {

    margin-left: 2px;

}


</style>


{{-- =========================================================
     JAVASCRIPT GANTI FOTO
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

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

            if (this.files.length > 0) {

                formGantiFoto.submit();

            }

        });

    }

});

</script>