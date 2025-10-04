import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

const swiperDA = document.querySelector('.doctors-academic');

if (swiperDA) {
    const swiper = new Swiper(swiperDA, {
        modules: [Navigation, Pagination, Autoplay],
        slidesPerGroup: 1,     // geser 1 slide per swipe
        loop: true,
        freeMode: true,
        freeModeMomentum: false,       // jangan snap
        allowTouchMove: false,         // biar tidak bisa drag manual
        speed: 5000,                   // makin besar makin lambat geraknya
        autoplay: {
            delay: 0,                  // tidak ada jeda
            disableOnInteraction: false,
        },
        spaceBetween: 20,
        breakpoints: {
            0: {          // Mobile
                slidesPerView: 3,
                spaceBetween: 5,
            },
            640: {        // Tablet
                slidesPerView: 4,
                spaceBetween: 15,
            },
            1024: {       // Desktop
                slidesPerView: 8,
                spaceBetween: 20,
            },
        },
    });
} else {
    console.error("⚠️ Swiper: Tidak dapat menemukan elemen dengan class 'doctors-academic'");
}

window.slugify = function (text) {
    return text
        .toString()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
};
