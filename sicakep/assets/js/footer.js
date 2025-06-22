// // JavaScript untuk memastikan footer tetap di bawah konten

// function fixFooter() {
//     const footer = document.querySelector('footer');
//     const main = document.querySelector('main');

//     // Jika tinggi konten lebih kecil dari tinggi layar, pindahkan footer ke bawah
//     if (main.offsetHeight < window.innerHeight) {
//         footer.style.position = 'absolute';
//         footer.style.bottom = '0';
//     } else {
//         footer.style.position = 'relative';
//         footer.style.bottom = 'initial';
//     }
// }

// // Jalankan fungsi saat halaman dimuat dan saat ukuran layar berubah
// window.addEventListener('load', fixFooter);
// window.addEventListener('resize', fixFooter);
