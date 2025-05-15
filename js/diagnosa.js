// Fungsi untuk menampilkan modal konfirmasi saat tombol "Diagnosa" diklik
document.addEventListener('click', function (event) {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    // Periksa apakah klik terjadi di luar navbar dan navbar sedang terbuka
    if (navbarCollapse.classList.contains('show') && !navbarToggler.contains(event.target) && !navbarCollapse.contains(event.target)) {
        navbarToggler.click(); // Tutup navbar
    }
});

document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
    const checkedGejala = document.querySelectorAll('input[type=radio]:checked');
    let totalDipilih = 0;

    const gejalaDipilih = {};
    checkedGejala.forEach((input) => {
        const name = input.name;
        if (input.value !== "0") {
            gejalaDipilih[name] = true;
        }
    });

    totalDipilih = Object.keys(gejalaDipilih).length;

    if (totalDipilih < 1 || totalDipilih > 5) {
        alert("Silakan pilih minimal 1 dan maksimal 5 gejala.");
        e.preventDefault();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.querySelector('button[type="submit"]');
    const radioInputs = document.querySelectorAll('input[type="radio"]');

    // Matikan tombol saat pertama kali load
    submitButton.disabled = true;

    function checkSelection() {
        let anySelected = false;

        // Periksa jika ada radio yang terpilih
        radioInputs.forEach(input => {
            if (input.checked) {
                anySelected = true;
            }
        });

        // Aktifkan / nonaktifkan tombol
        submitButton.disabled = !anySelected;
    }

    // Tambahkan event listener ke semua radio
    radioInputs.forEach(input => {
        input.addEventListener('change', checkSelection);
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // cegah submit langsung

        Swal.fire({
            title: 'Sedang mendiagnosa...',
            html: 'Mohon tunggu sebentar.',
            timer: 3000, // waktu dalam milidetik (3000 = 3 detik)
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                let timerInterval = setInterval(() => {
                    b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                }, 100);
            },
            willClose: () => {
                form.submit(); // submit form setelah loading selesai
            }
        });
    });
});
