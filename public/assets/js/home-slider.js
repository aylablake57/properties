var swiper = new Swiper('.swiper', {
    // Optional parameters
    /* direction: 'vertical', */
    loop: true,
    spaceBetween: 0,
    slidesPerView: 5,

    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },

    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        1024: {
            slidesPerView: 5,
            spaceBetween: 0
        },
        768: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        540: {
            slidesPerView: 1,
            spaceBetween: 4
        },
        320: {
            slidesPerView: 1,
            spaceBetween: 2
        },
    }
});

var swiper = new Swiper('.featured-swiper', {
    loop: true,
    spaceBetween: 30,
    slidesPerView: 4,

    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },

    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        1024: {
            slidesPerView: 4,
            spaceBetween: 0
        },
        768: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        540: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        320: {
            slidesPerView: 1,
            spaceBetween: 0
        },
    }
});
