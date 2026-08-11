@extends('layouts.app')

@section('title', 'Ekspor Dokumen')

@section('content')

<style>

/* =========================================================
   EXPORT PAGE
   FONT DISESUAIKAN DENGAN HALAMAN UPLOAD / KELOLA DOKUMEN
========================================================= */

.export-page,
.export-page *,
.export-hero,
.export-hero *,
.export-center,
.export-center *,
.export-main,
.export-main *,
.export-preview,
.export-preview *,
.export-breadcrumb,
.export-breadcrumb *,
.export-form,
.export-form *,
.export-filter-grid,
.export-filter-grid *,
.export-actions,
.export-actions * {
    font-family: 'Inter', sans-serif !important;
}

.export-page {
    width: 100%;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.export-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: 16px;

    font-size: 14px;
    font-weight: 400;
}

.export-breadcrumb a {
    color: #1d4ed8;
    text-decoration: none;
    font-weight: 500;
}

.export-breadcrumb a:hover {
    text-decoration: underline;
}

.export-breadcrumb span {
    color: #64748b;
}


/* =========================================================
   HERO
========================================================= */

.export-hero {
    position: relative;

    min-height: 160px;

    display: flex;
    align-items: center;

    gap: 26px;

    padding: 26px 36px;

    overflow: hidden;

    border: 1px solid #8dbaff;
    border-top: 3px solid #1769e8;

    border-radius: 22px;

    background:
        radial-gradient(
            circle at 92% 10%,
            rgba(255,255,255,.75) 0,
            rgba(255,255,255,.35) 115px,
            transparent 116px
        ),
        linear-gradient(
            110deg,
            #eaf3ff 0%,
            #dceaff 50%,
            #eef6ff 100%
        );

    box-shadow:
        0 10px 28px rgba(29,78,216,.06);
}


/* =========================================================
   HERO DECORATION
========================================================= */

.export-hero::before {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -35px;
    top: -105px;

    border-radius: 50%;

    border: 1px solid rgba(255,255,255,.8);

    pointer-events: none;
}


.export-hero-decoration {
    position: absolute;

    right: 115px;
    top: 48px;

    color: rgba(255,255,255,.85);

    font-size: 22px;

    pointer-events: none;
}


/* =========================================================
   HERO ICON
========================================================= */

.ekspor-hero-icon-ring {
    position: relative;

    width: 80px;
    height: 80px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: rgba(255,255,255,.65);

    border: 3px solid rgba(255,255,255,.85);

    box-shadow:
        0 8px 22px rgba(23,105,232,.12);
}


.ekspor-hero-icon {
    width: 64px;
    height: 64px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #103f80;

    color: white;

    font-size: 27px;

    box-shadow:
        inset 0 0 0 2px rgba(255,255,255,.12),
        0 7px 18px rgba(16,63,128,.22);
}


/* =========================================================
   HERO CONTENT
   DISESUAIKAN DENGAN KELOLA / UPLOAD DOKUMEN
========================================================= */

.export-hero-content {
    position: relative;
    z-index: 2;
}


.export-hero-content h2 {
    margin: 0 0 6px;

    color: #253657;

    font-size: 32px;

    font-weight: 700;

    line-height: 1.25;

    letter-spacing: -0.3px;
}


.export-hero-content p {
    margin: 0;

    color: #60708a;

    font-size: 15px;

    font-weight: 400;

    line-height: 1.5;
}


/* =========================================================
   EXPORT CENTER
========================================================= */

.export-center {
    display: grid;

    grid-template-columns:
        minmax(0, 1.55fr)
        minmax(300px, .75fr);

    overflow: hidden;

    border-radius: 22px;

    background: white;

    box-shadow:
        0 10px 35px rgba(15,43,83,.08);

    border: 1px solid #edf1f6;
}


/* =========================================================
   EXPORT MAIN
========================================================= */

.export-main {
    padding: 34px 38px;
}


/* =========================================================
   HEADING
========================================================= */

.export-heading {
    display: flex;

    align-items: flex-start;

    gap: 16px;

    padding-bottom: 22px;

    border-bottom: 1px solid #edf0f4;
}


.export-heading-icon {
    width: 58px;
    height: 58px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #e9f2ff;

    color: #1769e8;

    font-size: 25px;
}


.export-kicker {
    display: block;

    margin-bottom: 3px;

    color: #6680a3;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 1.4px;
}


.export-heading h4 {
    margin: 0 0 4px;

    color: #17345f;

    font-size: 21px;

    font-weight: 700;

    line-height: 1.3;
}


.export-heading p {
    margin: 0;

    color: #718096;

    font-size: 13px;

    font-weight: 400;

    line-height: 1.5;
}


/* =========================================================
   FORM
========================================================= */

.export-form-wrapper {
    padding-top: 25px;
}


.export-form {
    margin-bottom: 20px;
}


.export-form label {
    display: block;

    margin-bottom: 8px;

    color: #263b5c;

    font-size: 14px;

    font-weight: 600;
}


.export-form small {
    display: block;

    margin-top: 7px;

    color: #7b8798;

    font-size: 12px;

    font-weight: 400;

    line-height: 1.5;
}


/* =========================================================
   FILTER GRID
========================================================= */

.export-filter-grid {
    display: grid;

    grid-template-columns:
        1.4fr
        1fr
        1fr
        1fr;

    gap: 14px;

    margin-top: 18px;
}


.export-filter-item {
    min-width: 0;
}


.export-filter-item label {
    display: block;

    margin-bottom: 8px;

    color: #334155;

    font-size: 13px;

    font-weight: 600;
}


/* =========================================================
   SELECT & INPUT
========================================================= */

.export-select,
.export-input {
    width: 100%;

    min-height: 50px;

    padding: 0 14px;

    border: 1px solid #dce4ee;

    border-radius: 11px;

    background: white;

    color: #263b5c;

    font-family: 'Inter', sans-serif !important;

    font-size: 14px;

    font-weight: 400;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}


.export-select:focus,
.export-input:focus {
    border-color: #1769e8;

    box-shadow:
        0 0 0 3px rgba(23,105,232,.10);
}


/* =========================================================
   DATE INPUT
========================================================= */

.export-date-wrapper {
    position: relative;

    width: 100%;
}


.export-date-input {
    width: 100%;

    min-height: 50px;

    padding:
        0 44px 0 14px !important;

    cursor: pointer;

    background: white !important;
}


.export-date-input::placeholder {
    color: #94a3b8;
}


.export-date-input:hover {
    border-color: #b8c9df;
}


.export-date-icon {
    position: absolute;

    right: 15px;
    top: 50%;

    transform: translateY(-50%);

    color: #1769e8;

    font-size: 17px;

    pointer-events: none;
}


/* =========================================================
   FILTER BUTTON
========================================================= */

.export-filter-actions {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 9px;

    margin-top: 14px;
}


.export-reset {
    min-height: 38px;

    padding: 0 14px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    border: 1px solid #dce4ee;

    border-radius: 9px;

    background: #fff;

    color: #64748b;

    font-size: 12px;

    font-weight: 600;

    text-decoration: none;

    transition: .2s;
}


.export-reset:hover {
    background: #f5f7fa;

    color: #334155;
}


/* =========================================================
   FILTER INFO
========================================================= */

.export-filter-info {
    display: flex;

    align-items: flex-start;

    gap: 10px;

    margin-top: 18px;

    padding: 12px 14px;

    border: 1px solid #d9eef8;

    border-radius: 11px;

    background: #f1fbff;

    color: #55728e;

    font-size: 12px;

    font-weight: 400;

    line-height: 1.5;
}


.export-filter-info i {
    flex-shrink: 0;

    margin-top: 1px;

    color: #1689bd;

    font-size: 15px;
}


/* =========================================================
   EXPORT INFO
========================================================= */

.export-info {
    display: flex;

    align-items: flex-start;

    gap: 11px;

    margin-top: 20px;

    padding: 14px 16px;

    border: 1px solid #ccebf5;

    border-radius: 11px;

    background: #f1fbff;

    color: #55728e;

    font-size: 12px;

    font-weight: 400;

    line-height: 1.55;
}


.export-info i {
    flex-shrink: 0;

    margin-top: 2px;

    color: #1592c4;

    font-size: 16px;
}


/* =========================================================
   ACTIONS
========================================================= */

.export-actions {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    padding-top: 24px;

    margin-top: 24px;

    border-top: 1px solid #edf0f4;
}


.export-cancel,
.export-submit {
    min-height: 47px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    border-radius: 11px;

    font-size: 14px;

    font-weight: 600;

    text-decoration: none;

    transition: .2s;

    font-family: 'Inter', sans-serif !important;
}


.export-cancel {
    padding: 0 17px;

    border: 1px solid #dce4ee;

    background: white;

    color: #64748b;
}


.export-cancel:hover {
    background: #f6f8fb;

    color: #334155;
}


.export-submit {
    padding: 0 20px;

    border: 1px solid #123f80;

    background: #123f80;

    color: white;

    box-shadow:
        0 7px 16px rgba(18,63,128,.18);
}


.export-submit:hover {
    background: #0d3268;

    border-color: #0d3268;

    color: white;

    transform: translateY(-1px);
}


/* =========================================================
   PREVIEW
========================================================= */

.export-preview {
    position: relative;

    min-height: 500px;

    display: flex;

    flex-direction: column;

    align-items: center;
    justify-content: center;

    overflow: hidden;

    background:
        radial-gradient(
            circle at 85% 12%,
            rgba(255,255,255,.65) 0,
            rgba(255,255,255,.2) 120px,
            transparent 121px
        ),
        linear-gradient(
            145deg,
            #e5f0ff 0%,
            #cfe3ff 100%
        );
}


/* =========================================================
   ORBIT
========================================================= */

.export-orbit {
    position: absolute;

    border-radius: 50%;

    border: 1px solid rgba(255,255,255,.8);

    pointer-events: none;
}


.export-orbit-1 {
    width: 280px;
    height: 280px;

    right: -120px;
    top: 22px;
}


.export-orbit-2 {
    width: 230px;
    height: 230px;

    left: -120px;
    bottom: -105px;
}


/* =========================================================
   PREVIEW ICON
========================================================= */

.export-preview-icon {
    position: relative;

    z-index: 2;

    width: 120px;
    height: 120px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 25px;

    background: #123f80;

    color: white;

    font-size: 50px;

    box-shadow:
        0 15px 30px rgba(18,63,128,.22);
}


.export-preview-title {
    position: relative;

    z-index: 2;

    margin-top: 30px;

    color: #173f7c;

    font-size: 36px;

    line-height: 1;

    font-weight: 800;

    letter-spacing: 2px;
}


.export-preview-subtitle {
    position: relative;

    z-index: 2;

    margin-top: 8px;

    color: #7690b1;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: 4px;
}


.export-preview-badge {
    position: relative;

    z-index: 2;

    margin-top: 26px;

    padding: 9px 15px;

    display: inline-flex;

    align-items: center;

    gap: 7px;

    border-radius: 20px;

    background: rgba(255,255,255,.82);

    color: #34805f;

    font-size: 12px;

    font-weight: 600;
}


.export-preview-badge i {
    color: #26a269;
}


/* =========================================================
   AIR DATEPICKER
   BIRU - PUTIH GRADASI
========================================================= */

.air-datepicker {
    width: 310px !important;

    border: 1px solid #dbe5f1 !important;

    border-radius: 18px !important;

    overflow: hidden !important;

    background: #fff !important;

    box-shadow:
        0 18px 45px rgba(15,42,80,.18) !important;

    font-family: 'Inter', sans-serif !important;

    z-index: 9999 !important;
}


/* =========================================================
   HEADER KALENDER
========================================================= */

.air-datepicker-nav {
    height: 70px !important;

    padding: 0 12px !important;

    display: flex !important;

    align-items: center !important;

    background:
        linear-gradient(
            135deg,
            #0A2E6E 0%,
            #12377E 55%,
            #1E4FA0 100%
        ) !important;

    border: none !important;
}


/* =========================================================
   JUDUL BULAN & TAHUN
========================================================= */

.air-datepicker-nav--title {
    color: #fff !important;

    font-family: 'Inter', sans-serif !important;

    font-size: 15px !important;

    font-weight: 700 !important;

    line-height: 1.2 !important;

    padding: 7px 10px !important;

    border-radius: 8px !important;

    transition: .2s ease;
}


.air-datepicker-nav--title:hover {
    background: rgba(255,255,255,.10) !important;
}


.air-datepicker-nav--title i {
    color: #dbeafe !important;

    margin-left: 3px !important;
}


/* =========================================================
   PANAH
========================================================= */

.air-datepicker-nav--action {
    width: 34px !important;
    height: 34px !important;

    flex-shrink: 0 !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 9px !important;

    background: rgba(255,255,255,.12) !important;

    transition:
        background .2s ease,
        transform .2s ease !important;
}


.air-datepicker-nav--action:hover {
    background: rgba(255,255,255,.22) !important;

    transform: translateY(-1px);
}


.air-datepicker-nav--action path {
    stroke: #fff !important;
}


/* =========================================================
   BODY
========================================================= */

.air-datepicker-body {
    padding: 12px 14px 7px !important;

    margin: 0 !important;

    background: #fff !important;
}


/* =========================================================
   NAMA HARI
========================================================= */

.air-datepicker-body--day-names {
    margin-bottom: 5px !important;
}


.air-datepicker-body--day-name {
    color: #64748b !important;

    font-family: 'Inter', sans-serif !important;

    font-size: 10px !important;

    font-weight: 700 !important;

    line-height: 28px !important;

    text-transform: uppercase !important;
}


/* =========================================================
   TANGGAL
========================================================= */

.air-datepicker-cell {
    width: 36px !important;
    height: 36px !important;

    margin: 1px !important;

    display: flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 10px !important;

    color: #334155 !important;

    font-family: 'Inter', sans-serif !important;

    font-size: 12px !important;

    font-weight: 500 !important;

    transition:
        background .15s ease,
        color .15s ease,
        transform .15s ease !important;
}


/* =========================================================
   HOVER
========================================================= */

.air-datepicker-cell:hover {
    background: #eaf2ff !important;

    color: #1769e8 !important;
}


/* =========================================================
   HARI INI
========================================================= */

.air-datepicker-cell.-current- {
    color: #1769e8 !important;

    font-weight: 700 !important;

    border: 2px solid #1769e8 !important;

    background: transparent !important;
}


/* =========================================================
   TANGGAL DIPILIH
========================================================= */

.air-datepicker-cell.-selected- {
    background:
        linear-gradient(
            135deg,
            #0A2E6E,
            #1E4FA0
        ) !important;

    color: #fff !important;

    font-weight: 700 !important;

    border: none !important;

    box-shadow:
        0 4px 10px rgba(10,46,110,.22) !important;
}


.air-datepicker-cell.-selected-:hover {
    background:
        linear-gradient(
            135deg,
            #0A2E6E,
            #1E4FA0
        ) !important;

    color: #fff !important;
}


/* =========================================================
   BULAN LAIN
========================================================= */

.air-datepicker-cell.-other-month- {
    color: #cbd5e1 !important;
}


/* =========================================================
   TANGGAL DISABLED
========================================================= */

.air-datepicker-cell.-disabled- {
    color: #cbd5e1 !important;

    cursor: not-allowed !important;
}


/* =========================================================
   FOOTER
========================================================= */

.air-datepicker-buttons {
    display: flex !important;

    align-items: center !important;

    justify-content: flex-end !important;

    gap: 6px !important;

    padding: 8px 12px !important;

    border-top: 1px solid #edf1f6 !important;

    background: #fafcff !important;
}


.air-datepicker-button {
    height: 32px !important;

    padding: 0 11px !important;

    display: inline-flex !important;

    align-items: center !important;
    justify-content: center !important;

    border-radius: 8px !important;

    color: #1769e8 !important;

    font-family: 'Inter', sans-serif !important;

    font-size: 11px !important;

    font-weight: 600 !important;

    transition: .2s ease !important;
}


.air-datepicker-button:hover {
    background: #eaf2ff !important;

    color: #1257c7 !important;
}


/* =========================================================
   DARK MODE
========================================================= */

body.dark-mode .export-breadcrumb span {
    color: #94a3b8;
}


body.dark-mode .export-breadcrumb a {
    color: #60a5fa;
}


/* =========================================================
   DARK HERO
========================================================= */

body.dark-mode .export-hero {
    border-color: #315d96;

    background:
        radial-gradient(
            circle at 92% 10%,
            rgba(255,255,255,.08) 0,
            rgba(255,255,255,.03) 115px,
            transparent 116px
        ),
        linear-gradient(
            110deg,
            #202f45 0%,
            #1e3049 50%,
            #243850 100%
        );

    box-shadow:
        0 10px 30px rgba(0,0,0,.22);
}


body.dark-mode .export-hero::before {
    border-color: rgba(148,163,184,.15);
}


body.dark-mode .export-hero-content h2 {
    color: #f1f5f9;
}


body.dark-mode .export-hero-content p {
    color: #a9bad0;
}


body.dark-mode .export-hero-decoration {
    color: rgba(255,255,255,.3);
}


body.dark-mode .ekspor-hero-icon-ring {
    background: rgba(255,255,255,.08);

    border-color: rgba(255,255,255,.18);
}


/* =========================================================
   DARK EXPORT CENTER
========================================================= */

body.dark-mode .export-center {
    background: #1e293b;

    border-color: #334155;

    box-shadow:
        0 10px 35px rgba(0,0,0,.24);
}


body.dark-mode .export-heading {
    border-color: #334155;
}


body.dark-mode .export-heading-icon {
    background: #243b5c;

    color: #60a5fa;
}


body.dark-mode .export-kicker {
    color: #94a3b8;
}


body.dark-mode .export-heading h4 {
    color: #f1f5f9;
}


body.dark-mode .export-heading p {
    color: #94a3b8;
}


/* =========================================================
   DARK FORM
========================================================= */

body.dark-mode .export-form label,
body.dark-mode .export-filter-item label {
    color: #e2e8f0;
}


body.dark-mode .export-form small {
    color: #94a3b8;
}


body.dark-mode .export-select,
body.dark-mode .export-input {
    border-color: #475569;

    background: #111827;

    color: #e2e8f0;
}


body.dark-mode .export-select:focus,
body.dark-mode .export-input:focus {
    border-color: #3b82f6;

    box-shadow:
        0 0 0 3px rgba(59,130,246,.12);
}


body.dark-mode .export-date-input {
    background: #111827 !important;

    border-color: #475569 !important;

    color: #e2e8f0 !important;
}


body.dark-mode .export-date-input::placeholder {
    color: #64748b;
}


body.dark-mode .export-date-icon {
    color: #60a5fa;
}


/* =========================================================
   DARK RESET
========================================================= */

body.dark-mode .export-reset {
    border-color: #475569;

    background: #1e293b;

    color: #cbd5e1;
}


body.dark-mode .export-reset:hover {
    background: #334155;

    color: white;
}


/* =========================================================
   DARK INFO
========================================================= */

body.dark-mode .export-filter-info,
body.dark-mode .export-info {
    border-color: #28516a;

    background: #172d3a;

    color: #a9c4d8;
}


body.dark-mode .export-filter-info i,
body.dark-mode .export-info i {
    color: #60c5ee;
}


/* =========================================================
   DARK ACTIONS
========================================================= */

body.dark-mode .export-actions {
    border-color: #334155;
}


body.dark-mode .export-cancel {
    border-color: #475569;

    background: #1e293b;

    color: #cbd5e1;
}


body.dark-mode .export-cancel:hover {
    background: #334155;

    color: white;
}


/* =========================================================
   DARK PREVIEW
========================================================= */

body.dark-mode .export-preview {
    background:
        radial-gradient(
            circle at 85% 12%,
            rgba(255,255,255,.07) 0,
            rgba(255,255,255,.02) 120px,
            transparent 121px
        ),
        linear-gradient(
            145deg,
            #1e3a5f 0%,
            #1e344f 100%
        );
}


body.dark-mode .export-orbit {
    border-color: rgba(148,163,184,.18);
}


body.dark-mode .export-preview-title {
    color: #8ec5ff;
}


body.dark-mode .export-preview-subtitle {
    color: #94a3b8;
}


body.dark-mode .export-preview-badge {
    background: rgba(255,255,255,.09);

    color: #86efac;
}


/* =========================================================
   DARK DATEPICKER
========================================================= */

body.dark-mode .air-datepicker {
    background: #1e293b !important;

    border-color: #334155 !important;

    box-shadow:
        0 20px 50px rgba(0,0,0,.45) !important;
}


body.dark-mode .air-datepicker-body {
    background: #1e293b !important;
}


body.dark-mode .air-datepicker-body--day-name {
    color: #94a3b8 !important;
}


body.dark-mode .air-datepicker-cell {
    color: #e2e8f0 !important;
}


body.dark-mode .air-datepicker-cell:hover {
    background: #263b58 !important;

    color: #60a5fa !important;
}


body.dark-mode .air-datepicker-cell.-other-month- {
    color: #475569 !important;
}


body.dark-mode .air-datepicker-cell.-current- {
    color: #60a5fa !important;

    border-color: #60a5fa !important;
}


body.dark-mode .air-datepicker-buttons {
    background: #172131 !important;

    border-color: #334155 !important;
}


body.dark-mode .air-datepicker-button {
    color: #60a5fa !important;
}


body.dark-mode .air-datepicker-button:hover {
    background: #263b58 !important;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .export-center {
        grid-template-columns: 1fr;
    }

    .export-preview {
        min-height: 360px;
    }

    .export-filter-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}


@media (max-width: 768px) {

    .export-hero {
        padding: 24px;

        gap: 18px;
    }


    .export-hero-content h2 {
        font-size: 25px;
    }


    .export-hero-content p {
        font-size: 13px;
    }


    .ekspor-hero-icon-ring {
        width: 68px;
        height: 68px;
    }


    .ekspor-hero-icon {
        width: 54px;
        height: 54px;

        font-size: 23px;
    }


    .export-main {
        padding: 25px 20px;
    }


    .export-heading {
        gap: 12px;
    }


    .export-heading h4 {
        font-size: 18px;
    }


    .export-filter-grid {
        grid-template-columns: 1fr;
    }


    .export-actions {
        flex-direction: column-reverse;

        align-items: stretch;
    }


    .export-cancel,
    .export-submit {
        width: 100%;
    }


    .export-preview {
        min-height: 330px;
    }


    .air-datepicker {
        width: 310px !important;
    }

}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .export-submit,
    .export-cancel,
    .export-reset {
        transition: none;
    }

}

</style>


{{-- =========================================================
     EXPORT PAGE
========================================================= --}}

<div class="export-page">


    {{-- =====================================================
         BREADCRUMB
    ====================================================== --}}

    <div class="export-breadcrumb">

        <a href="{{ route('dashboard') }}">
            Beranda
        </a>

        <span>›</span>

        <span>
            Ekspor Dokumen
        </span>

    </div>


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="export-hero">

        <div class="ekspor-hero-icon-ring">

            <div class="ekspor-hero-icon">

                <i class="bi bi-file-earmark-zip-fill"></i>

            </div>

        </div>


        <div class="export-hero-content">

            <h2 class="fw-bold">
                Ekspor Dokumen
            </h2>

            <p>
                Pilih kategori dan periode dokumen sebelum
                mengemas arsip menjadi satu file ZIP.
            </p>

        </div>


        <div class="export-hero-decoration">

            <i class="bi bi-stars"></i>

        </div>

    </div>


    {{-- =====================================================
         EXPORT CENTER
    ====================================================== --}}

    <div class="export-center mt-4">


        {{-- =================================================
             LEFT : FORM EKSPOR
        ================================================== --}}

        <div class="export-main">


            {{-- =================================================
                 HEADING
            ================================================== --}}

            <div class="export-heading">

                <div class="export-heading-icon">

                    <i class="bi bi-folder2-open"></i>

                </div>


                <div>

                    <span class="export-kicker">
                        EXPORT CENTER
                    </span>


                    <h4>
                        Pilih dokumen yang akan diekspor
                    </h4>


                    <p>
                        Gunakan filter untuk membatasi dokumen
                        yang akan dimasukkan ke dalam file ZIP.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 FORM
            ================================================== --}}

            <form
                action="{{ route('dokumen.export.process') }}"
                method="POST"
            >

                @csrf


                <div class="export-form-wrapper">


                    {{-- =================================================
                         KATEGORI
                    ================================================== --}}

                    <div class="export-form">

                        <label for="kategori_id">
                            Kategori Dokumen
                        </label>


                        <select
                            name="kategori_id"
                            id="kategori_id"
                            class="export-select"
                        >

                            <option value="">
                                Seluruh Dokumen
                            </option>


                            @foreach ($kategoris as $kategori)

                                <option
                                    value="{{ $kategori->id }}"
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}
                                >
                                    {{ $kategori->nama }}
                                </option>

                            @endforeach

                        </select>


                        <small>
                            Pilih kategori tertentu atau
                            <strong>Seluruh Dokumen</strong>
                            jika tidak ingin membatasi berdasarkan kategori.
                        </small>

                    </div>


                    {{-- =================================================
                         FILTER PERIODE
                    ================================================== --}}

                    <div class="export-filter-grid">


                        {{-- TAHUN --}}

                        <div class="export-filter-item">

                            <label for="tahun">
                                Tahun
                            </label>


                            <select
                                name="tahun"
                                id="tahun"
                                class="export-select"
                            >

                                <option value="">
                                    Semua Tahun
                                </option>


                                @php
                                    $tahunSekarang = now()->year;
                                    $tahunAwal = $tahunSekarang - 10;
                                @endphp


                                @for (
                                    $tahun = $tahunSekarang;
                                    $tahun >= $tahunAwal;
                                    $tahun--
                                )

                                    <option
                                        value="{{ $tahun }}"
                                        {{ old('tahun') == $tahun ? 'selected' : '' }}
                                    >
                                        {{ $tahun }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- BULAN --}}

                        <div class="export-filter-item">

                            <label for="bulan">
                                Bulan
                            </label>


                            <select
                                name="bulan"
                                id="bulan"
                                class="export-select"
                            >

                                <option value="">
                                    Semua Bulan
                                </option>

                                @php
                                    $namaBulan = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ];
                                @endphp


                                @foreach ($namaBulan as $nomorBulan => $nama)

                                    <option
                                        value="{{ $nomorBulan }}"
                                        {{ old('bulan') == $nomorBulan ? 'selected' : '' }}
                                    >
                                        {{ $nama }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- TANGGAL --}}

                        <div class="export-filter-item">

                            <label for="tanggal">
                                Tanggal
                            </label>


                            <div class="export-date-wrapper">

                                <input
                                    type="text"
                                    name="tanggal"
                                    id="tanggal"
                                    class="export-input export-date-input"
                                    value="{{ old('tanggal') }}"
                                    placeholder="Pilih tanggal"
                                    autocomplete="off"
                                    readonly
                                >


                                <i class="bi bi-calendar3 export-date-icon"></i>

                            </div>

                        </div>


                        {{-- RESET --}}

                        <div class="export-filter-item d-flex align-items-end">

                            <a
                                href="{{ route('dokumen.export') }}"
                                class="export-reset w-100"
                            >

                                <i class="bi bi-arrow-counterclockwise"></i>

                                Reset Filter

                            </a>

                        </div>

                    </div>


                    {{-- =================================================
                         INFO FILTER
                    ================================================== --}}

                    <div class="export-filter-info">

                        <i class="bi bi-funnel-fill"></i>

                        <span>

                            Filter berdasarkan
                            <strong>
                                kategori, tahun, bulan, dan tanggal
                            </strong>
                            akan diterapkan saat proses ekspor.
                            Kosongkan filter yang tidak ingin digunakan.

                        </span>

                    </div>


                    {{-- =================================================
                         INFO ZIP
                    ================================================== --}}

                    <div class="export-info">

                        <i class="bi bi-info-circle-fill"></i>

                        <span>

                            Dokumen yang sesuai dengan filter akan
                            dikemas menjadi satu file
                            <strong>ZIP</strong>.
                            File PDF akan tetap dikelompokkan
                            berdasarkan kategori.

                        </span>

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="export-actions">

                        <a
                            href="{{ route('dokumen.index') }}"
                            class="export-cancel"
                        >

                            <i class="bi bi-arrow-left"></i>

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="export-submit"
                        >

                            <i class="bi bi-file-earmark-zip-fill"></i>

                            Ekspor ke ZIP

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- =================================================
             RIGHT : PREVIEW
        ================================================== --}}

        <div class="export-preview">

            <div class="export-orbit export-orbit-1"></div>

            <div class="export-orbit export-orbit-2"></div>


            <div class="export-preview-icon">

                <i class="bi bi-file-earmark-zip-fill"></i>

            </div>


            <div class="export-preview-title">
                EXPORT
            </div>


            <div class="export-preview-subtitle">
                ZIP ARCHIVE
            </div>


            <div class="export-preview-badge">

                <i class="bi bi-check-circle-fill"></i>

                Siap diekspor

            </div>

        </div>

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="text-center py-4">

        <small class="text-muted">

            © 2026 BULOG. All rights reserved.

        </small>

    </div>

</div>


{{-- =========================================================
     AIR DATEPICKER CSS
========================================================= --}}

@push('styles')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.css"
>

@endpush


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ELEMENT
    ===================================================== */

    const tahun =
        document.getElementById('tahun');

    const bulan =
        document.getElementById('bulan');

    const tanggal =
        document.getElementById('tanggal');


    if (!tanggal) {
        return;
    }


    /* =====================================================
       TAHUN SISTEM
    ===================================================== */

    const currentYear =
        {{ now()->year }};


    /* =====================================================
       DATEPICKER
    ===================================================== */

    const datepicker =
        new AirDatepicker('#tanggal', {

            locale: {

                days: [
                    'Minggu',
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu'
                ],

                daysShort: [
                    'Min',
                    'Sen',
                    'Sel',
                    'Rab',
                    'Kam',
                    'Jum',
                    'Sab'
                ],

                daysMin: [
                    'Mg',
                    'Sn',
                    'Sl',
                    'Rb',
                    'Km',
                    'Jm',
                    'Sb'
                ],

                months: [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ],

                monthsShort: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agt',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],

                today: 'Hari ini',

                clear: 'Hapus',

                dateFormat: 'dd/MM/yyyy',

                firstDay: 1

            },


            /* =================================================
               BATAS TANGGAL
            ================================================= */

            minDate:
                new Date(
                    currentYear - 10,
                    0,
                    1
                ),

            maxDate:
                new Date(
                    currentYear,
                    11,
                    31
                ),


            /* =================================================
               TOMBOL FOOTER
            ================================================= */

            buttons: [
                'today',
                'clear'
            ],


            /* =================================================
               POSISI
            ================================================= */

            position: 'bottom left',


            /* =================================================
               AUTO CLOSE
            ================================================= */

            autoClose: true,


            /* =================================================
               KETIKA TANGGAL DIPILIH
            ================================================= */

            onSelect({ date }) {

                if (!date) {
                    return;
                }


                const selectedYear =
                    date.getFullYear();


                const selectedMonth =
                    date.getMonth() + 1;


                /* ---------------------------------------------
                   SET TAHUN
                --------------------------------------------- */

                if (tahun) {

                    const yearExists =
                        Array.from(
                            tahun.options
                        ).some(
                            option =>
                                parseInt(option.value) ===
                                selectedYear
                        );


                    if (yearExists) {

                        tahun.value =
                            selectedYear;

                    }

                }


                /* ---------------------------------------------
                   SET BULAN
                --------------------------------------------- */

                if (bulan) {

                    bulan.value =
                        selectedMonth;

                }

            }

        });


    /* =====================================================
       VALIDASI TANGGAL TERHADAP TAHUN & BULAN
    ===================================================== */

    function validateTanggal() {

        if (!tanggal.value) {
            return;
        }


        const parts =
            tanggal.value.split('/');


        if (parts.length !== 3) {
            return;
        }


        const selectedDay =
            parseInt(parts[0], 10);


        const selectedMonth =
            parseInt(parts[1], 10);


        const selectedYear =
            parseInt(parts[2], 10);


        if (
            isNaN(selectedDay) ||
            isNaN(selectedMonth) ||
            isNaN(selectedYear)
        ) {

            return;

        }


        /* =================================================
           TAHUN TIDAK SESUAI
        ================================================= */

        if (
            tahun &&
            tahun.value &&
            parseInt(tahun.value, 10) !== selectedYear
        ) {

            tanggal.value = '';

            datepicker.clear();

            return;

        }


        /* =================================================
           BULAN TIDAK SESUAI
        ================================================= */

        if (
            bulan &&
            bulan.value &&
            parseInt(bulan.value, 10) !== selectedMonth
        ) {

            tanggal.value = '';

            datepicker.clear();

        }

    }


    /* =====================================================
       TAHUN BERUBAH
    ===================================================== */

    if (tahun) {

        tahun.addEventListener(
            'change',
            validateTanggal
        );

    }


    /* =====================================================
       BULAN BERUBAH
    ===================================================== */

    if (bulan) {

        bulan.addEventListener(
            'change',
            validateTanggal
        );

    }


    /* =====================================================
       LOAD OLD DATE
    ===================================================== */

    const oldTanggal =
        tanggal.value;


    if (oldTanggal) {

        const parts =
            oldTanggal.split('/');


        if (parts.length === 3) {

            const day =
                parseInt(parts[0], 10);

            const month =
                parseInt(parts[1], 10) - 1;

            const year =
                parseInt(parts[2], 10);


            if (
                !isNaN(day) &&
                !isNaN(month) &&
                !isNaN(year)
            ) {

                const oldDate =
                    new Date(
                        year,
                        month,
                        day
                    );


                datepicker.selectDate(
                    oldDate,
                    {
                        silent: true
                    }
                );

            }

        }

    }

});

</script>

@endpush

@endsection