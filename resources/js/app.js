import '../css/app.css';
import 'flowbite';



document.addEventListener("DOMContentLoaded", () => {
    // Cek apakah sedang di halaman landing-page
    if (document.body.classList.contains('landing-page')) {
        import('./Landing.js')
            .then(module => {
                if (typeof module.default === 'function') {
                    module.default();
                }
            })
            .catch(err => {
                console.error("Gagal load Landing.js:", err);
            });
    }

    // Navigasi manual untuk horizontal scroll testimonial
    const wrapper = document.getElementById('testimonialWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (wrapper && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            wrapper.scrollBy({ left: -wrapper.clientWidth, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            wrapper.scrollBy({ left: wrapper.clientWidth, behavior: 'smooth' });
        });
    }
});
