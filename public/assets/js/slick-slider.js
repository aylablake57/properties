//  Home section Logo Slider added by Hamza Amjad (Slick-slider)
$(document).ready(function(){
    $('.slick-slider').slick({
        infinite: true,
        slidesToShow: 6, 
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000, 
        cssEase: 'linear',
        arrows: false, 
        dots: false,   
        pauseOnHover: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2, /* Adjust the number of logos for small screens */
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1, /* Further adjust for smaller screens */
                    slidesToScroll: 1,
                }
            }
        ]
    });
});
// //{{-- Js added by Hamza Amjad as for repeating same color for testimonial card, added by Hamza Amjad --}}
// document.addEventListener('DOMContentLoaded', () => {
//     // Array of predefined background colors for the first 5 cards
//     const cardColors = ['#a0af50', '#49556B', '#ababab', '#545454', '#18202D'];

//     // Select all testimonial cards
//     const testimonialCards = document.querySelectorAll('.testimonial-card');

//     // Loop through all testimonial cards beyond the first 5 and assign random colors
//     testimonialCards.forEach((card, index) => {
//         if (index >= 5) {
//             const randomColor = cardColors[Math.floor(Math.random() * cardColors.length)];
//             card.style.backgroundColor = randomColor;
//         }
//     });
// });