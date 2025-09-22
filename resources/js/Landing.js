import Swiper, { Navigation } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';

export default function () {
    console.log("Landing.js loaded");

    // Animasi teks (yang sudah kamu buat)
    const heroText = document.querySelector('.hero-text');
    if (heroText) {
        heroText.style.opacity = 0;
        heroText.style.transition = "opacity 1s ease";
        setTimeout(() => {
            heroText.style.opacity = 1;
        }, 300);
    }

    // Inisialisasi Swiper
    const swiperContainer = document.querySelector('.mySwiper');
    if (swiperContainer) {
        console.log("Swiper inisialisasi dari Landing.js");
        new Swiper('.mySwiper', {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }
}
