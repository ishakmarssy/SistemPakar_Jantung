document.addEventListener('click', function (event) {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    // Periksa apakah klik terjadi di luar navbar dan navbar sedang terbuka
    if (navbarCollapse.classList.contains('show') && !navbarToggler.contains(event.target) && !navbarCollapse.contains(event.target)) {
        navbarToggler.click(); // Tutup navbar
    }
});