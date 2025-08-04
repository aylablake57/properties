// Ensure the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to radio buttons
    document.querySelectorAll('input[name="style"]').forEach(radio => {
        radio.addEventListener('change', function() {
            switchMapStyle(this.value);
        });
    });
});

// Function to switch map style
function switchMapStyle(styleId) {
    map.setStyle(`mapbox://styles/mapbox/${styleId}`);
}

// Mapbox Added By Hamza Amjad
mapboxgl.accessToken = 'pk.eyJ1IjoiaGFtemEwMzE4NzUzMzMiLCJhIjoiY2x6czNuYWg5MjRzZjJscXdzMTFjZWRtZCJ9.GDbTGTy6QwbmGLAsDXpoZA';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [69.3451, 30.3753], // Center of Pakistan
    zoom: 4.5 // Adjust zoom level to show the whole country
});

// Add navigation control
map.addControl(new mapboxgl.NavigationControl());

// Store markers in an array
let markers = [];
let categoryMarkers = [];

// Add custom markers for DHA cities
const dhaCities = [
    { name: 'DHA City Karachi', coordinates: [67.4488, 25.0380] },
    { name: 'DHA City Lahore', coordinates: [74.3436, 31.5497] },
    { name: 'DHA City Peshawar', coordinates: [71.5785, 34.0080] },
    { name: 'DHA City Islamabad', coordinates: [73.0974, 33.5424] },
    { name: 'DHA City Multan', coordinates: [71.5249, 30.0329] },
    { name: 'DHA City Gujranwala', coordinates: [74.1883, 32.1617] },
    { name: 'DHA City Hyderabad', coordinates: [68.3737, 25.3924] },
    { name: 'DHA City Faisalabad', coordinates: [71.6752, 29.3978] }
];

map.on('load', () => {
    dhaCities.forEach(city => {
        const marker = new mapboxgl.Marker({
            element: createCustomMarkerElement()
        })
        .setLngLat(city.coordinates)
        .setPopup(new mapboxgl.Popup({ offset: 25 }).setText(city.name))
        .addTo(map);

        markers.push(marker); // Add marker to the array
    });
});

// Create custom marker element
function createCustomMarkerElement() {
    const markerDiv = document.createElement('div');
    markerDiv.className = 'custom-marker';
    markerDiv.style.backgroundImage = `url(${customMarkerUrl})`;
    markerDiv.style.backgroundSize = 'contain';
    markerDiv.style.width = '50px'; // Set width of marker
    markerDiv.style.height = '50px'; // Set height of marker
    markerDiv.style.backgroundRepeat = 'no-repeat';
    return markerDiv;
}

// Hide all markers
function hideAllMarkers() {
    markers.forEach(marker => {
        marker.getElement().style.display = 'none';
    });
}

// Show all markers
function showAllMarkers() {
    markers.forEach(marker => {
        marker.getElement().style.display = 'block';
    });
    map.flyTo({ center: [69.3451, 30.3753], zoom: 5 }); // Zoom out to show all markers
}

// Function to set city phase
function setCityPhase(lng, lat, phase) {
    hideAllMarkers();
    clearCategoryMarkers();

    const marker = new mapboxgl.Marker({
        element: createCustomMarkerElement()
    })
    .setLngLat([lng, lat])
    .setPopup(new mapboxgl.Popup({ offset: 25 }).setText(phase))
    .addTo(map);

    markers.push(marker); // Add this marker to the array

    // Fly to the selected phase's coordinates
    map.flyTo({
        center: [lng, lat],
        zoom: 14,
        speed: 0.8, // Lower speed for a slower transition
        curve: 1.5, // Higher curve for smoother animation
        easing: function (t) {
            return t; // Linear easing
        },
        duration: 3000 // Duration in milliseconds
    });
}

// Show user's current location
document.getElementById('location-button').addEventListener('click', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userCoordinates = [position.coords.longitude, position.coords.latitude];
            map.flyTo({ center: userCoordinates, zoom: 14 });
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

// Event listener for "Show All Markers" button
document.getElementById('show-all-markers').addEventListener('click', showAllMarkers);

// Event listener for fullscreen button
document.getElementById('fullscreen').addEventListener('click', () => {
    if (!document.fullscreenElement) {
        const mapContainer = document.getElementById('map');
        mapContainer.requestFullscreen().catch(err => {
            console.error(`Error attempting to enable full-screen mode: ${err.message}`);
        });
    } else {
        document.exitFullscreen();
    }
});

$(document).ready(function () {
    $('#city-dropdown').on('change', function () {
        var cityID = this.value;
        $("#location-dropdown").html('');
        $.ajax({
            url: "locations",
            type: "GET",
            data: {
                id: cityID,
            },
            dataType: 'json',
            success: function (result) {
                $("#location-dropdown").html('<option value="">Select</option>');
                $.each(result, function (key, value) {
                    $("#location-dropdown").append('<option value="' + value
                        .name + '">' + value.name + '</option>');
                });
            }
        });
    });
    $("#location-dropdown").on("change", function() {
        if ($('#city-dropdown').val() == 7) { // for Gujranwala
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(74.1342595261949, 32.248181126193835, 'DHA Phase 1');
            } else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(74.13863323235745, 32.25563914623212, 'DHA Phase 2');
            }
        } else if ($('#city-dropdown').val() == 8) { // for Quetta
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(66.85185019083373, 30.65766103954037, 'DHA Phase 1');
            }
        } else if ($('#city-dropdown').val() == 1) { // for Islamabad
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(73.09897184569043, 33.5403325421607, 'DHA Phase 1');
            } else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(73.16452761891001, 33.539800296708854, 'DHA Phase 2');
            } else if ($("#location-dropdown").val() == 'Phase 3') {
                setCityPhase(73.14471861943208, 33.5039586599537, 'DHA Phase 3');
            } else if ($("#location-dropdown").val() == 'Phase 4') {
                setCityPhase(73.07891171663431, 33.51862694614104, 'DHA Phase 4');
            } else if ($("#location-dropdown").val() == 'Phase 5') {
                setCityPhase(73.20909135264063, 33.534982895041836, 'DHA Phase 5');
            } else if ($("#location-dropdown").val() == 'Phase 6 (DHA Valley)') {
                setCityPhase(73.23616075339946, 33.52886438999772, 'DHA Phase 6 (DHA Valley)');
            } else if ($("#location-dropdown").val() == 'Phase 7') {
                setCityPhase(73.11285537433112, 33.5319117768432, 'DHA Phase 7');
            } else if ($("#location-dropdown").val() == 'Phase 9 (DHA Expressway)') {
                setCityPhase(73.04297987541794, 33.504165429713915, 'Phase 9 (DHA Expressway)');
            }
        } else if ($('#city-dropdown').val() == 2) { // for Lahore
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(74.39655111686861,31.485123401506126, 'DHA Phase 1');
            } else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(74.40840250450816,31.480914757729217, 'DHA Phase 2');
            } else if ($("#location-dropdown").val() == 'Phase 3') {
                setCityPhase(74.37337631534228,31.475789624792913, 'DHA Phase 3');
            } else if ($("#location-dropdown").val() == 'Phase 4') {
                setCityPhase(74.38501742940257,31.467349445111964, 'DHA Phase 4');
            } else if ($("#location-dropdown").val() == 'Phase 5') {
                setCityPhase(74.408499576849, 31.464519447665957, 'DHA Phase 5');
            } else if ($("#location-dropdown").val() == 'Phase 6') {
                setCityPhase(74.45788243456332,31.474736507898275, 'DHA Phase 6');
            } else if ($("#location-dropdown").val() == 'Phase 7') {
                setCityPhase(74.49305420294583,31.468958986367515, 'DHA Phase 7');
            } else if ($("#location-dropdown").val() == 'Phase 8') {
                setCityPhase(74.44990492109687,31.493469679750106, 'DHA Phase 8');
            } else if ($("#location-dropdown").val() == 'Phase 9 Town') {
                setCityPhase(74.43793070191474,31.439161282941782, 'DHA Phase 9 (Town)');
            } else if ($("#location-dropdown").val() == 'Phase 9 Prism') {
                setCityPhase(74.27360476864528,31.466220848370078, 'DHA Phase 9 (Prism)');
            } else if ($("#location-dropdown").val() == 'Phase 10') {
                setCityPhase(74.38369577478713, 31.46016424415494, 'DHA Phase 10');
            } else if ($("#location-dropdown").val() == 'Phase 11 (Rahbar)') {
                setCityPhase(74.27003770233786,31.379640921050022, 'DHA Phase 11 (Rahbar)');
            } else if ($("#location-dropdown").val() == 'Phase 12 (EME)') {
                setCityPhase(74.20912228150252,31.438108473578744, 'DHA Phase 12 (EME)');
            }
        } else if ($('#city-dropdown').val() == 3) { // for Karachi
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(67.06599137493235, 24.845411951207065, 'DHA Phase 1');
            } else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(67.05535647856595, 24.836530369879757, 'DHA Phase 2');
            } else if ($("#location-dropdown").val() == 'Phase 2 Extension') {
                setCityPhase(67.06811288567506, 24.835153495475183, 'DHA Phase 2 Extension');
            } else if ($("#location-dropdown").val() == 'Phase 3') {
                setCityPhase(67.07886571693095, 24.84138637424945, 'DHA Phase 3');
            } else if ($("#location-dropdown").val() == 'Phase 4') {
                setCityPhase(67.07276535845584, 24.832991829542596, 'DHA Phase 4');
            }
        } else if ($('#city-dropdown').val() == 4) { // for Multan
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(71.52799623682702, 30.29000146442831,  'DHA Phase 1');
            }else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(71.48729177065891, 30.250560583578075, 'DHA Phase 2');
        }else if ($('#city-dropdown').val() == 5) { // for Peshawar
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(71.43403929205367, 34.05477797985862, 'DHA Phase 1');
            }
        } else if ($('#city-dropdown').val() == 6) { // for Bahawalpur
            if ($("#location-dropdown").val() == 'Phase 1') {
                setCityPhase(71.67691085424869, 29.328420424710913, 'DHA Phase 1');
            } else if ($("#location-dropdown").val() == 'Phase 2') {
                setCityPhase(71.74823812847578, 29.371163650740268, 'DHA Phase 2');
            }
        }
        }
    });
}); 

// Add categories and corresponding markers
// const phaseCategories = {
//     'DHA Phase 1': {
//         restaurant: [/* Restaurants in DHA Phase 1 */],
//         schools: [/* Schools in DHA Phase 1 */],
//         parks: [/* Parks in DHA Phase 1 */],
//         hospitals: [/* Hospitals in DHA Phase 1 */],
//         barberShop: [/* Barber Shops in DHA Phase 1 */],
//         mosques: [/* Mosques in DHA Phase 1 */],
//         complex: [/* Complexes in DHA Phase 1 */],
//         malls: [/* Malls in DHA Phase 1 */],
//         banks: [/* Banks in DHA Phase 1 */]
//     },
//     'DHA Phase 2': {
//         restaurant: [/* Restaurants in DHA Phase 2 */],
//         schools: [/* Schools in DHA Phase 2 */],
//         parks: [/* Parks in DHA Phase 2 */],
//         hospitals: [/* Hospitals in DHA Phase 2 */],
//         barberShop: [/* Barber Shops in DHA Phase 2 */],
//         mosques: [/* Mosques in DHA Phase 2 */],
//         complex: [/* Complexes in DHA Phase 2 */],
//         malls: [/* Malls in DHA Phase 2 */],
//         banks: [/* Banks in DHA Phase 2 */]
//     },
//     // Add data for other phases similarly
// };



// Event listeners for category buttons
// document.getElementById('restaurant').addEventListener('click', () => addCategoryMarkers('restaurant'));
// document.getElementById('schools').addEventListener('click', () => addCategoryMarkers('schools'));
// document.getElementById('parks').addEventListener('click', () => addCategoryMarkers('parks'));
// document.getElementById('hospitals').addEventListener('click', () => addCategoryMarkers('hospitals'));
// document.getElementById('all-categories').addEventListener('click', () => {
//     ['restaurant', 'schools', 'parks', 'hospitals'].forEach(category => addCategoryMarkers(category));
// });

const categories = {
    restaurant: [
        { name: 'Abbasi Naan Center', coordinates: [33.54066706592933, 73.10222913844031] },
        { name: 'Tandoori Restaurant', coordinates: [33.523944940912955, 73.10675229830291] },
        // Add more restaurants as needed
    ],
    schools: [
        { name: 'APS DHA Phase 1', coordinates: [33.54356564771192, 73.08999634993613] },
        { name: 'Roots School System', coordinates: [33.54126620594526, 73.10023893933996] },
        { name: 'Roots School Junior Campus', coordinates: [33.540640238700185, 73.10076465231374] },
        { name: 'DHA Orchard', coordinates: [33.53329948534897, 73.08951355224411] },
        // Add more schools as needed
    ],
    parks: [
        { name: 'Overseas 1 children Park', coordinates: [33.506251076199, 73.09270001667697] },
        { name: 'Defence Villas Children Park', coordinates: [33.507789770734135, 73.09287167805616] },
        { name: 'Family Park', coordinates: [33.53948794518684, 73.0954573275662] },
        { name: 'Avenue Park', coordinates: [33.54227350181334, 73.09578992150689] },
        { name: 'Riverview Park', coordinates: [33.538632641680124, 73.10379554849952] },
        { name: 'Cornic Park west', coordinates: [33.53517177479713, 73.10076465231153] },
        { name: 'Bottle Brush Park', coordinates: [33.5450053166849, 73.08940626444118] },
        // Add more parks as needed
    ],
    hospitals: [
        { name: 'Fauji Foundation Hospital', coordinates: [33.55427482783867, 73.0957950105291] },
        { name: 'Riphah International Hospital', coordinates: [33.54136908809269, 73.186116042803] },
        { name: 'UHealth International Hospital', coordinates: [33.51655416581635, 73.16686510452634] },
        { name: 'Institute of Regenerative Medicine (IRM Hospital)', coordinates: [33.51611096661139, 73.16736579950313] },

        
        // Add more hospitals as needed
    ],
    barberShop: [
        { name: 'DHA Barber Shop', coordinates: [33.53331608496349, 73.10311426740613] },
        { name: 'Riphah International Hospital', coordinates: [33.54136908809269, 73.186116042803] },
        { name: 'UHealth International Hospital', coordinates: [33.51655416581635, 73.16686510452634] },
        { name: 'Institute of Regenerative Medicine (IRM Hospital)', coordinates: [33.51611096661139, 73.16736579950313] },
        
    ],
    mosques: [
        { name: 'Masjid Sector B', coordinates: [33.545819032299605, 73.09278584734803] },
        { name: 'Masjid Gulzar', coordinates: [33.54947850478377, 73.0943254925487] },
        { name: 'Shafi Mosque', coordinates: [33.54008133551121, 73.10237397771984] },
        { name: 'Sector E Mosque', coordinates: [33.524892486370305, 73.10793496382223] },
        { name: 'Masjid o.orch', coordinates: [33.53357672351873, 73.08626807932477] },
        { name: 'Jāmi Masjid Al-Falāh', coordinates: [33.53872782590459, 73.09092439417125] },
        // Add more schools as needed
    ],
    complex: [
        { name: 'Riverview Sports Complex', coordinates: [33.530187731386974, 73.10791101261259] },
        { name: 'Masjid Gulzar', coordinates: [33.54947850478377, 73.0943254925487] },
        { name: 'Shafi Mosque', coordinates: [33.54008133551121, 73.10237397771984] },
        // Add more schools as needed
    ],
    malls: [
        { name: 'Defence Avenue Mall', coordinates: [33.54229585745145, 73.09661604188041] },
        { name: 'The Leather Posh (shoe store)', coordinates: [33.54224091736357, 73.09976687056229] },
        { name: 'Family Park', coordinates: [33.53948794518684, 73.0954573275662] },
        { name: 'Avenue Park', coordinates: [33.54227350181334, 73.09578992150689] },
        { name: 'Avenue Park', coordinates: [33.53326371261921, 73.08783985381629] },
        // Add more parks as needed
    ],

    banks: [
        { name: 'Allied Bank', coordinates: [33.5460068116681, 73.09473849559454] },
        { name: 'Defence Villas Children Park', coordinates: [33.507789770734135, 73.09287167805616] },
        { name: 'Family Park', coordinates: [33.53948794518684, 73.0954573275662] },
        { name: 'Avenue Park', coordinates: [33.54227350181334, 73.09578992150689] },
        // Add more parks as needed
    ],
};

function clearCategoryMarkers() {
    categoryMarkers.forEach(marker => marker.remove());
    categoryMarkers = [];
}

// Function to add category markers
function addCategoryMarkers(category) {
    clearCategoryMarkers();

    categories[category].forEach(location => {
        const marker = new mapboxgl.Marker({
            element: createCustomMarkerElement()
        })
        .setLngLat(location.coordinates)
        .setPopup(new mapboxgl.Popup({ offset: 25 }).setText(location.name))
        .addTo(map);

        categoryMarkers.push(marker);
    });
}

// Function to switch map style
function switchMapStyle(styleId) {
    map.setStyle(`mapbox://styles/mapbox/${styleId}`);
}

// Add event listeners to radio buttons
document.querySelectorAll('input[name="style"]').forEach(radio => {
    radio.addEventListener('change', function() {
        switchMapStyle(this.value);
    });
});

document.querySelectorAll('input[name="style"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const selectedStyle = this.value;
        map.setStyle(`mapbox://styles/mapbox/${selectedStyle}`);
    });
});