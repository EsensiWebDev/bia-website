import Swiper from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/thumbs";

import { Navigation, Pagination, Autoplay, Thumbs } from "swiper/modules";
document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Swiper initializing...");
    const swiperDA = document.querySelector(".doctors-academic");
    const mainSwiperEl = document.querySelector(".ours-doctors");
    const thumbsSwiperEl = document.querySelector(".doctors-thumbs");
    const detailsList = document.querySelectorAll("details.faq");
    const image = document.getElementById("faq-image");

    if (swiperDA) {
        const swiper = new Swiper(swiperDA, {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerGroup: 1, // geser 1 slide per swipe
            loop: true,
            freeMode: true,
            freeModeMomentum: false, // jangan snap
            allowTouchMove: false, // biar tidak bisa drag manual
            speed: 5000, // makin besar makin lambat geraknya
            autoplay: {
                delay: 0, // tidak ada jeda
                disableOnInteraction: false,
            },
            spaceBetween: 20,
            breakpoints: {
                0: {
                    // Mobile
                    slidesPerView: 3,
                    spaceBetween: 5,
                },
                640: {
                    // Tablet
                    slidesPerView: 4,
                    spaceBetween: 15,
                },
                1024: {
                    // Desktop
                    slidesPerView: 8,
                    spaceBetween: 20,
                },
            },
        });
    } else {
        console.error(
            "⚠️ Swiper: Tidak dapat menemukan elemen dengan class 'doctors-academic'",
        );
    }

    if (mainSwiperEl && thumbsSwiperEl) {
        // === Thumbnail Swiper ===
        const thumbsSwiper = new Swiper(thumbsSwiperEl, {
            slidesPerView: 2,
            spaceBetween: 15,
            freeMode: true,
            watchSlidesProgress: true,
            grabCursor: true,
            breakpoints: {
                640: { slidesPerView: 4 },
                768: { slidesPerView: 5 },
                1024: { slidesPerView: 5 },
            },
        });

        // === Main Swiper ===
        new Swiper(mainSwiperEl, {
            modules: [Navigation, Thumbs],
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });
    } else {
        console.warn(
            "⚠️ Swiper: .ours-doctors atau .doctors-thumbs tidak ditemukan.",
        );
    }

    detailsList.forEach((detail) => {
        detail.addEventListener("toggle", () => {
            if (detail.open) {
                // Tutup semua detail lain
                detailsList.forEach((other) => {
                    if (other !== detail) other.open = false;
                });

                // Ganti gambar
                const newImg = detail.getAttribute("data-img");
                if (newImg && image) {
                    image.classList.add("opacity-0", "scale-95");
                    setTimeout(() => {
                        image.src = newImg;
                        image.classList.remove("opacity-0", "scale-95");
                    }, 200);
                }
            }
        });
    });

    window.slugify = function (text) {
        return text
            .toString()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    };
});
