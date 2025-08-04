$(document).ready(function () {
    var location = getUrlParameter('location');
    var subType = getUrlParameter('sub_type');

    let cityId = $('#city-dropdown').val();
    if (cityId) {
        getLocation(cityId , location);
    }
    //Populate Sub-Type dropdown - Edit Form
    // let typeName = $('#property_type').val();
    //let subTypeId = "{{ $property?->sub_type }}";

    // if (typeName) {
    //     getSubTypes(typeName , subType);
    // }

    if (getUrlParameter('min_price')) { 
        $('#minPrice').val(new Intl.NumberFormat("PKR" , {
            style: "currency",
            currency: "PKR",
            minimumFractionDigits: 0,
        }).format(getUrlParameter('min_price')));
    }

    if (getUrlParameter('max_price')) $('#maxPrice').val(new Intl.NumberFormat().format(getUrlParameter('max_price')));

    if (getUrlParameter('min_area')) $('#areaMinInput').val(getUrlParameter('min_area'));
    if (getUrlParameter('max_area')) $('#areaMaxInput').val(getUrlParameter('max_area'));

});



$('#city-dropdown').on('change', function () {
    getLocation(this.value);
});

function getLocation(cityId , location)
{
    if (!location) {
        location = 'all';
    }
    $("#location-dropdown").html('');
    $.ajax({
        url: 'locations',
        type: "GET",
        data: {
            id: cityId,
        },
        dataType: 'json',
        success: function (result) {
            $("#location-dropdown").html('<option value="all">All</option>');
            $.each(result, function (key, value) {
                $("#location-dropdown").append('<option value="' + value
                    .id + '">' + value.name + '</option>');
            });

            $("#location-dropdown").val(location);
        }
    });
}

$(document).on('click' , '#minPrice li' , function() {
    $('#minPrice li').removeClass('active');
    $(this).addClass('active');
    var minPriceValue = $(this).text();
    $('#minPriceSpan').text(minPriceValue);
    $('#min_price_field').val(minPriceValue.split(",").join(""));
});

$(document).on('click' , '#maxPrice li' , function() {
    $('#maxPrice li').removeClass('active');
    $(this).addClass('active');
    var maxPriceValue = $(this).text();
    $('#maxPriceSpan').text(maxPriceValue);
    $('#max_price_field').val(maxPriceValue.split(",").join(""));
});

$(document).on('click' , '#btnReset' , function() {
    $('#minPriceSpan').text('0');
    $('#maxPriceSpan').text('Any');
    $('#min_price_field').val("");
    $('#max_price_field').val("");
});

/* For Price Slider */
/* Code by Hamza Amjad */
/* Function to format numbers to LAKH or CRORE */
function formatNumber(num) {
    const crore = 10000000;
    const lakh = 100000;
    
    if (num >= crore) {
        return (num % crore === 0 ? (num / crore) : (num / crore).toFixed(2)) + ' crore';
    } else if (num >= lakh) {
        return (num % lakh === 0 ? (num / lakh) : (num / lakh).toFixed(2)) + ' lac';
    } else {
        return num.toLocaleString(); // Simple formatting for numbers less than lakh
    }
}

/* For Price Slider */
const rangevalue = document.querySelector(".slider-container .price-slider");
const rangeInputvalue = document.querySelectorAll(".range-input input");

// Set the price gap
let priceGap = 23000000;

// Adding event listeners to price input elements
const priceInputvalue = document.querySelectorAll(".price-input input");
const minPriceHint = document.getElementById("minPriceHint");
const maxPriceHint = document.getElementById("maxPriceHint");

for (let i = 0; i < priceInputvalue.length; i++) {
    priceInputvalue[i].addEventListener("input", e => {
        let minp = parseInt(priceInputvalue[0].value, 10);
        let maxp = parseInt(priceInputvalue[1].value, 10);

        // Set default values if parsed values are NaN
        minp = isNaN(minp) ? 5000000 : minp;
        maxp = isNaN(maxp) ? 500000000 : maxp;

        minp = Math.max(minp, 5000000);

        maxp = Math.min(maxp, 500000000);

        if (minp > maxp - priceGap) {
            minp = maxp - priceGap;
        }

        if (maxp < minp + priceGap) {
            maxp = minp + priceGap;
        }

        if (minp < 5000000) {
            minp = 5000000;
        }

        priceInputvalue[0].value = minp;
        priceInputvalue[1].value = maxp;

        if (e.target.className.includes("min-input")) {
            rangeInputvalue[0].value = minp;
            rangevalue.style.left = `${((minp - 5000000) / 495000000) * 100}%`;
            minPriceHint.textContent = formatNumber(minp);
        } else {
            rangeInputvalue[1].value = maxp;
            rangevalue.style.right = `${100 - ((maxp - 5000000) / 495000000) * 100}%`;
            maxPriceHint.textContent = formatNumber(maxp);
        }
    });
}

// Add event listeners to range input elements
for (let i = 0; i < rangeInputvalue.length; i++) {
    rangeInputvalue[i].addEventListener("input", e => {
        let minVal = parseInt(rangeInputvalue[0].value);
        let maxVal = parseInt(rangeInputvalue[1].value);

        // Set default values if parsed values are NaN
        minVal = isNaN(minVal) ? 5000000 : minVal;
        maxVal = isNaN(maxVal) ? 500000000 : maxVal;

        if (maxVal - minVal < priceGap) {
            if (e.target.className.includes("min-range")) {
                rangeInputvalue[0].value = maxVal - priceGap;
            } else {
                rangeInputvalue[1].value = minVal + priceGap;
            }
        } else {
            minVal = Math.max(minVal, 5000000);
            maxVal = Math.min(maxVal, 500000000);

            priceInputvalue[0].value = minVal;
            priceInputvalue[1].value = maxVal;
            rangevalue.style.left = `${((minVal - 5000000) / 495000000) * 100}%`;
            rangevalue.style.right = `${100 - ((maxVal - 5000000) / 495000000) * 100}%`;
            minPriceHint.textContent = formatNumber(minVal);
            maxPriceHint.textContent = formatNumber(maxVal);
        }
    });
}

/* For Area Slider */
/* Code by Hamza Amjad */
function updateAreaHint(minArea, maxArea) {
    document.getElementById('minAreaHint').textContent = minArea;
    document.getElementById('maxAreaHint').textContent = maxArea;
}

// For Area Slider
const areaSlider = document.querySelector(".area-slider-container .area-range-slider");
const areaRangeInputs = document.querySelectorAll(".area-range-input input");

let areaGap = 3;

// Adding event listeners to area input elements
const areaInputs = document.querySelectorAll(".area-input input");
for (let i = 0; i < areaInputs.length; i++) {
    areaInputs[i].addEventListener("input", e => {
        let minArea = parseInt(areaInputs[0].value, 10) || 0;
        let maxArea = parseInt(areaInputs[1].value, 10) || 50;

        minArea = Math.max(0, minArea);
        maxArea = Math.min(50, maxArea);
        if (minArea < 0) {
            minArea = 0;
            areaInputs[0].value = minArea;
        }

        if (maxArea > 50) {
            maxArea = 50;
            areaInputs[1].value = maxArea;
        }

        if (minArea > 49) {
            minArea = 49;
            areaInputs[0].value = minArea;
        }

        if (maxArea < 3) {
            maxArea = 3;
            areaInputs[1].value = maxArea;
        }

        if (minArea > maxArea - areaGap) {
            minArea = maxArea - areaGap;
            areaInputs[0].value = minArea;
        }

        if (maxArea < minArea + areaGap) {
            maxArea = minArea + areaGap;
            areaInputs[1].value = maxArea;
        }
        areaRangeInputs[0].value = minArea;
        areaRangeInputs[1].value = maxArea;
        updateSlider(minArea, maxArea);
        updateAreaHint(minArea, maxArea);  
    });
}

// Add event listeners to range input elements
for (let i = 0; i < areaRangeInputs.length; i++) {
    areaRangeInputs[i].addEventListener("input", e => {
        let minArea = parseInt(areaRangeInputs[0].value, 10) || 0;
        let maxArea = parseInt(areaRangeInputs[1].value, 10) || 50;

        if (maxArea - minArea < areaGap) {
            if (e.target.className.includes("area-min-range")) {
                minArea = maxArea - areaGap;
                areaRangeInputs[0].value = minArea;
            } else {
                maxArea = minArea + areaGap;
                areaRangeInputs[1].value = maxArea;
            }
        }

        areaInputs[0].value = minArea;
        areaInputs[1].value = maxArea;
        updateSlider(minArea, maxArea);
        updateAreaHint(minArea, maxArea);  
    });
}
document.querySelector("#areaMaxInput").addEventListener("input", e => {
    let maxArea = parseInt(e.target.value, 10) || 50;
    if (maxArea > 50) {
        e.target.value = 50;
        maxArea = 50;
    }
    let minArea = parseInt(document.querySelector("#areaMinInput").value, 10) || 0;

    if (minArea > maxArea - areaGap) {
        minArea = maxArea - areaGap;
        document.querySelector("#areaMinInput").value = minArea;
    }

    areaRangeInputs[0].value = minArea;
    areaRangeInputs[1].value = maxArea;
    updateSlider(minArea, maxArea);
    updateAreaHint(minArea, maxArea);
});
// Function to update the slider position
function updateSlider(minArea, maxArea) {
    areaSlider.style.left = `${(minArea / 50) * 100}%`;
    areaSlider.style.right = `${100 - (maxArea / 50) * 100}%`;
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
// Added by Hamza Amjad
$(document).ready(function () {
    // Set the default view to grid view
    $('#search-results .search-col').removeClass('col-lg-12').addClass('col-lg-4');
    $('#search-results .search-col .card').removeClass('d-flex flex-row');
    $('#search-results .search-col .card').attr('style', '');
    $('#search-results .search-col .card .card-img-top').attr('style', 'height:192px;');
    $('#search-results .search-col .card .card-body').attr('style', '');

    // Set grid view icon as active by default
    $('#btnGridView').addClass('active');
    $('.view-List-toggle').removeClass('active');
});
// Btn ListView
$(document).on('click', '#btnListView', function () {
    $('#search-results .search-col').removeClass('col-lg-4').addClass('col-lg-12');
    $('#search-results .search-col .card').addClass('d-flex flex-row');
    $('#search-results .search-col .card').attr('style', 'max-width:100% !important');
    $('#search-results .search-col .card .card-img-top').attr('style', 'height:290px;');
    $('#search-results .search-col .card .card-body').attr('style', 'width:80% !important');

    $('.view-grid-toggle').removeClass('active');
    $('#btnListView').addClass('active');
});
// Btn GridView
$(document).on('click', '#btnGridView', function () {
    $('#search-results .search-col').removeClass('col-lg-12').addClass('col-lg-4');
    $('#search-results .search-col .card').removeClass('d-flex flex-row');
    $('#search-results .search-col .card').attr('style', '');
    $('#search-results .search-col .card .card-img-top').attr('style', 'height:192px;');
    $('#search-results .search-col .card .card-body').attr('style', '');

    $('.view-List-toggle').removeClass('active');
    $('#btnGridView').addClass('active');
});
