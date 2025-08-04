let prevScrollPos = window.pageYOffset;
window.addEventListener('scroll', function() {
    const currentScrollPos = window.pageYOffset;
    if (prevScrollPos > currentScrollPos) {
        // user has scrolled up
        if (window.pageYOffset < 150) {
            $('header').attr('style' , '');
        }
    } else {
        // user has scrolled down
        if (window.pageYOffset > 150) {
            $('header').attr('style' , 'background-color:#fff;opacity:0.95;box-shadow: 3px 1px 20px 0 rgba(0, 110, 225, 0.08);');
        }
    }

    // update previous scroll position
    prevScrollPos = currentScrollPos;
});

$('#registerTab').hide();
$('#backToLogin').hide();

$(document).on('click' , '#registerLink' , function() {
    $('#loginTab').hide();
    $('#forgotPwLink').hide();
    $('#registerLink').hide();
    $('#registerTab').show();
    $('#backToLogin').show();
});

$(document).on('click' , '#backToLogin' , function() {
    $('#registerTab').hide();
    $('#backToLogin').hide();
    $('#loginTab').show();
    $('#forgotPwLink').show();
    $('#registerLink').show();
});

$(document).ready(function() {
    $('#send-contact-form').on('submit', function() {
        $(this).find('#submitButton').prop('disabled', true);
    });
});

let currentMarlaRate = 225;

const conversionRates = {
    sqft: 1,
    sqyd: 9,
    sqm: 10.7639,
    marla: currentMarlaRate,
    kanal: 20 * currentMarlaRate,
    acre: 36000,
    murabba: 900000,
    hectare: 90000
};

function setConversionRate(rate, element) {
    $('.toggle-button').removeClass('active-cal-area');
    currentMarlaRate = rate;
    // Update only the relevant conversion rates
    conversionRates.marla = rate;
    conversionRates.kanal = 20 * rate;
    conversionRates.sqft = 1;
    conversionRates.sqyd = 9;
    conversionRates.sqm = 10.7639;

    if (rate == 225) {
        conversionRates.acre = 36000;
        conversionRates.murabba = 900000;
        conversionRates.hectare = 90000;
    } else if (rate == 250) {
        conversionRates.acre = 40000;
        conversionRates.murabba = 1000000;
        conversionRates.hectare = 100000;
    } else {
        conversionRates.acre = 43520;
        conversionRates.murabba = 1088000;
        conversionRates.hectare = 108800;
    }

    // Recalculate areas using the updated conversion rates
    convertArea('input');
    
    // Remove active class from all span elements
    document.querySelectorAll('.badge').forEach(span => span.classList.remove('active-cal-area'));
    
    // Add active class to the clicked span element
    element.classList.add('active-cal-area');
}

function convertArea(source) {
    let inputValue = parseFloat(document.getElementById('inputValue').value);
    let outputValue = parseFloat(document.getElementById('outputValue').value);
    let inputUnit = document.getElementById('inputUnit').value;
    let outputUnit = document.getElementById('outputUnit').value;

    if (source === 'input') {
        if (!isNaN(inputValue)) {
            outputValue = inputValue * conversionRates[inputUnit] / conversionRates[outputUnit];
            document.getElementById('outputValue').value = outputValue.toFixed(2);
        } else {
            document.getElementById('outputValue').value = "";
        }
    } else if (source === 'output') {
        if (!isNaN(outputValue)) {
            inputValue = outputValue * conversionRates[outputUnit] / conversionRates[inputUnit];
            document.getElementById('inputValue').value = inputValue.toFixed(2);
        } else {
            document.getElementById('inputValue').value = "";
        }
    }
}

function setConversionUnit(firstVal , secondVal)
{
    $('#inputUnit').val(firstVal);
    $('#outputUnit').val(secondVal);
    convertArea('input');
}


const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// Function to close the ad banner
// function closeAdBanner() {
//     var adBanner = document.getElementById('ad-banner');
//     adBanner.style.display = 'none';
// }
document.addEventListener("DOMContentLoaded", function () {
    var adBanner = document.getElementById('ad-banner');
    var prevScrollPos = window.pageYOffset;

    // Check if the ad banner exists.
    if (!adBanner) {
        return;
    }
    // Hide ad banner on close button click
    function closeAdBanner() {
        adBanner.style.display = 'none';
        window.removeEventListener('scroll', handleScroll); // Stop checking for scroll if the user closes the banner
    }

    // Handle scroll behavior
    function handleScroll() {
        var currentScrollPos = window.pageYOffset;

        if (prevScrollPos < currentScrollPos) {
            // Scrolling down
            adBanner.style.display = 'none';
        } else if (currentScrollPos === 0) {
            // Back to top of the page
            adBanner.style.display = 'block';
        }

        prevScrollPos = currentScrollPos;
    }

    // Assign the close function to the close button
    if (document.querySelector('.close-btn')) {
        document.querySelector('.close-btn').addEventListener('click', closeAdBanner);
    }
    

    // Attach the scroll event listener
    window.addEventListener('scroll', handleScroll);
});

// nav-image-sale-link function added for active link
document.querySelectorAll('.nav-image-sale-link').forEach(link => {
    link.addEventListener('click', function() {
        document.querySelectorAll('.nav-image-sale-link').forEach(l => {
            l.classList.remove('active', 'show');
            l.querySelector('span').style.display = 'none';
        });
        this.classList.add('active', 'show');
        this.querySelector('span').style.display = 'inline';
    });
});

// Code added to check if the image, video, or map is availble or not? by Hamza Amjad, and swiper works perfect.
// By clicking on `nav-image-sale-link` data-type, It will display image if available, display map if available, display video if available
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper instances
    const swiper2 = new Swiper('.mySwiper2', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 3,
        spaceBetween: 10,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    const swiperVideo = new Swiper('.swiper-video', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    const swiperMap = new Swiper('.swiper-map', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    document.querySelectorAll('.nav-image-sale-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const type = this.getAttribute('data-type');

            // Hide all Swiper containers initially
            document.querySelectorAll('.swiper').forEach(swiper => {
                swiper.style.display = 'none';
            });

            // Show relevant Swiper container based on the clicked link
            if (type === 'image') {
                document.querySelector('.swiper.mySwiper2').style.display = 'block';
            } else if (type === 'video') {
                document.querySelector('.swiper-video').style.display = 'block';
            } else if (type === 'view-map') {
                document.querySelector('.swiper-map').style.display = 'block';
            }

            // Update active class on nav links
            document.querySelectorAll('.nav-image-sale-link').forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Trigger click on the initial active link to show the corresponding content
    if (document.querySelector('.nav-image-sale-link.active')) {
        document.querySelector('.nav-image-sale-link.active').click();
    }
    
});

window.addEventListener('click', function(event) {
    const dropdownToggle = document.getElementById('sortDropdownToggle');
    const dropdown = document.getElementById('sortDropdown');

    if (dropdownToggle && dropdown) {
        if (!dropdown.contains(event.target) && !dropdownToggle.contains(event.target)) {
            dropdownToggle.classList.remove('active');
            dropdown.classList.remove('active');
        }
    }
});