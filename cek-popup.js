

document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('files');
    const preview = document.getElementById('filePreview');
    const summary = document.getElementById('fileSummary');
    const fileCount = document.getElementById('fileCount');
    const btnUpload = document.getElementById('btnUpload');
    const btnChooseAgain = document.getElementById('btnChooseAgain');
    const dropzone = document.getElementById('dropzoneMany');
    const form = document.getElementById('uploadManyForm');

    function formatSize(bytes) {
        return (bytes / 1024 / 1024).toFixed(2) + ' MB';
    }

    function renderFiles() {

        preview.innerHTML = '';

        if (!fileInput.files.length) {
            preview.classList.add('d-none');
            summary.classList.add('d-none');
            btnUpload.disabled = true;
            return;
        }

        const files = Array.from(fileInput.files);

        summary.classList.remove('d-none');
        preview.classList.remove('d-none');
        btnUpload.disabled = false;

        fileCount.textContent =
            files.length + (files.length === 1 ? ' file' : ' file') +
            ' siap untuk diupload';

        const title = document.createElement('div');
        title.className = 'upload-many-preview-title';

        const titleText = document.createElement('span');
        titleText.textContent = 'Daftar file yang dipilih';

        const total = document.createElement('span');
        total.className = 'text-muted fw-normal';
        total.textContent = files.length + ' file';

        title.appendChild(titleText);
        title.appendChild(total);
        preview.appendChild(title);

        files.forEach(function (file, index) {

            const item = document.createElement('div');
            item.className = 'upload-many-file';

            const icon = document.createElement('div');
            icon.className = 'upload-many-file-icon';
            icon.innerHTML =
                '<i class="bi bi-file-earmark-pdf-fill"></i>';

            const info = document.createElement('div');
            info.className = 'upload-many-file-info';

            const name = document.createElement('span');
            name.className = 'upload-many-file-name';
            name.title = file.name;
            name.textContent = file.name;

            const size = document.createElement('span');
            size.className = 'upload-many-file-size';
            size.textContent = formatSize(file.size);

            info.appendChild(name);
            info.appendChild(size);

            const number = document.createElement('div');
            number.className = 'upload-many-file-number';
            number.textContent = index + 1;

            item.appendChild(icon);
            item.appendChild(info);
            item.appendChild(number);

            preview.appendChild(item);
        });
    }

    fileInput.addEventListener('change', renderFiles);

    btnChooseAgain.addEventListener('click', function () {
        fileInput.click();
    });

    ['dragover', 'dragleave', 'drop'].forEach(function (eventName) {
        dropzone.addEventListener(eventName, function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
    });

    dropzone.addEventListener('dragover', function () {
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function () {
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function (event) {

        dropzone.classList.remove('dragover');

        if (event.dataTransfer.files.length) {
            fileInput.files = event.dataTransfer.files;
            renderFiles();
        }
    });

    form.addEventListener('submit', async function (event) {
    event.preventDefault();

    if (btnUpload.disabled || fileInput.files.length === 0) {
        return;
    }

    const overlay = document.getElementById('bulogProcessingOverlay');
    const progressBar = document.getElementById('bulogProgressBar');
    const progressPercent = document.getElementById('bulogProgressPercent');
    const processingText = document.getElementById('bulogProcessingText');
    const uploadResults = document.getElementById('bulogUploadResults');

function tampilkanHasilUpload(items) {
    uploadResults.innerHTML = '';

    const bermasalah = (items || []).filter(item =>
        ['failed', 'duplicate'].includes(item.status)
    );

    if (bermasalah.length === 0) {
        uploadResults.style.display = 'none';
        return;
    }

    bermasalah.forEach(item => {
        const kotak = document.createElement('div');
        kotak.style.cssText =
            'padding:10px 12px; margin-bottom:8px; border-radius:8px;' +
            'background:#fff; border:1px solid #e5e7eb;';

        const nama = document.createElement('strong');
        nama.style.cssText = 'display:block; font-size:13px; overflow-wrap:anywhere;';
        nama.textContent =
            (item.status === 'failed' ? '❌ Gagal: ' : '⚠️ Duplikat: ') +
            item.original_filename;

        const alasan = document.createElement('div');
        alasan.style.cssText = 'font-size:12px; color:#64748b; margin-top:4px;';
        alasan.textContent = item.message || 'Tidak ada keterangan tambahan.';

        kotak.appendChild(nama);
        kotak.appendChild(alasan);
        uploadResults.appendChild(kotak);
    });

    uploadResults.style.display = 'block';
}
    const steps = document.querySelectorAll('.bulog-step');

    const originalButtonHtml = btnUpload.innerHTML;
    let selesai = false;

    function updateProgress(percent, message, activeStep) {
        const value = Math.max(0, Math.min(100, Number(percent) || 0));

        progressBar.style.width = value + '%';
        progressPercent.textContent = value + '%';
        processingText.textContent = message;

        steps.forEach(function (step, index) {
            step.classList.remove('active', 'done');

            if (index < activeStep) {
                step.classList.add('done');
            } else if (index === activeStep) {
                step.classList.add('active');
            }
        });
    }

    function tunggu(ms) {
        return new Promise(function (resolve) {
            setTimeout(resolve, ms);
        });
    }

    btnUpload.disabled = true;
    btnUpload.textContent = 'Memproses Dokumen...';

    overlay.classList.add('show');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    updateProgress(0, 'Mengunggah PDF ke server...', 0);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (!response.ok) {
            const firstError = result.errors
                ? Object.values(result.errors).flat()[0]
                : null;

            throw new Error(firstError || result.message || 'Upload gagal.');
        }

        if (!result.progress_url) {
            throw new Error('Alamat pemantauan progres tidak tersedia.');
        }

        updateProgress(0, 'PDF masuk antrean OCR...', 2);

        let gagalBerturut = 0;

        while (!selesai) {
            await tunggu(2000);

            let progressResponse;

            try {
                progressResponse = await fetch(result.progress_url, {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    cache: 'no-store'
                });

                if (!progressResponse.ok) {
                    throw new Error('Gagal membaca progres.');
                }

                gagalBerturut = 0;
            } catch (error) {
                gagalBerturut++;

                if (gagalBerturut >= 5) {
                    throw new Error(
                        'Koneksi pemantauan terputus. ' +
                        'Proses OCR mungkin masih berjalan di server.'
                    );
                }

                continue;
            }

            const data = await progressResponse.json();

            const total = Number(data.total_files) || 0;
            const processed = Number(data.processed_files) || 0;
            const percent = total > 0
                ? Math.min(100, Math.round(processed / total * 100))
                : 0;

            if (data.status === 'completed') {
                selesai = true;

                tampilkanHasilUpload(data.items);

                updateProgress(
                    100,
                    'Selesai! ' +
                    data.success_files + ' berhasil, ' +
                    data.duplicate_files + ' duplikat, ' +
                    data.failed_files + ' gagal.',
                    3
                );

                btnUpload.textContent = 'Selesai';

                if (Number(data.failed_files) === 0 &&
    Number(data.duplicate_files) === 0) {
    await tunggu(2500);
    window.location.reload();
}

return;
            }

            updateProgress(
                percent,
                processed + ' dari ' + total + ' PDF selesai diproses OCR...',
                2
            );
        }

    } catch (error) {
        updateProgress(
            Number.parseInt(progressPercent.textContent, 10) || 0,
            error.message || 'Terjadi kesalahan.',
            2
        );

        btnUpload.disabled = false;
        btnUpload.innerHTML = originalButtonHtml;

        // Jangan otomatis mengirim ulang PDF karena proses
        // sebelumnya mungkin sudah masuk antrean server.
        console.error('Upload Queue BULOG:', error);
    }
});


});


