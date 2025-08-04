
// document.getElementById('buyButton').addEventListener('click', function() {
//     this.classList.add('active'); // Highlight Buy
//     this.classList.remove('btn-outline-primary'); // Remove outline
//     this.classList.add('btn-primary'); // Add primary style

//     document.getElementById('rentButton').classList.remove('active'); // Remove highlight from Rent
//     document.getElementById('rentButton').classList.add('btn-outline-primary'); // Add outline
//     document.getElementById('rentButton').classList.remove('btn-primary'); // Remove primary style
// });

// document.getElementById('rentButton').addEventListener('click', function() {
//     this.classList.add('active'); // Highlight Rent
//     this.classList.remove('btn-outline-primary'); // Remove outline
//     this.classList.add('btn-primary'); // Add primary style

//     document.getElementById('buyButton').classList.remove('active'); // Remove highlight from Buy
//     document.getElementById('buyButton').classList.add('btn-outline-primary'); // Add outline
//     document.getElementById('buyButton').classList.remove('btn-primary'); // Remove primary style
// });


// slider js
const cardSlider = document.getElementById('cardSlider');
const leftButton = document.getElementById('leftButton');
const rightButton = document.getElementById('rightButton');

// Function to check the number of cards and display buttons accordingly
function toggleButtons() {
    const cards = cardSlider.children.length;
    if (cards <= 4) {
        leftButton.style.display = 'none';
        rightButton.style.display = 'none';
    } else {
        leftButton.style.display = 'block';
        rightButton.style.display = 'block';
    }
}

// Call the function to set the initial button visibility
toggleButtons();

// Function to scroll the slider
function scrollSlider(direction) {
    const cardWidth = cardSlider.children[0].offsetWidth; // Get the width of one card
    cardSlider.scrollLeft += direction * cardWidth; // Scroll to the left or right
}


// Treding locations
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector(".carousel-Top-Trending-Locations");
    const arrowBtns = document.querySelectorAll(".wrapper-Top-Trending-Locations i");
    const wrapper = document.querySelector(".wrapper-Top-Trending-Locations");

    const firstCard = carousel.querySelector(".card-Top-Trending-Locations");
    const firstCardWidth = firstCard.offsetWidth;

    let isDragging = false,
        startX,
        startScrollLeft,
        timeoutId;

    const dragStart = (e) => { 
        isDragging = true;
        carousel.classList.add("dragging");
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
    };

    const dragging = (e) => {
        if (!isDragging) return;
    
        // Calculate the new scroll position
        const newScrollLeft = startScrollLeft - (e.pageX - startX);
    
        // Check if the new scroll position exceeds 
        // the carousel boundaries
        if (newScrollLeft <= 0 || newScrollLeft >= 
            carousel.scrollWidth - carousel.offsetWidth) {
            
            // If so, prevent further dragging
            isDragging = false;
            return;
        }
    
        // Otherwise, update the scroll position of the carousel
        carousel.scrollLeft = newScrollLeft;
    };

    const dragStop = () => {
        isDragging = false; 
        carousel.classList.remove("dragging");
    };

    const autoPlay = () => {
    
        // Return if window is smaller than 800
        if (window.innerWidth < 800) return; 
        
        // Calculate the total width of all cards
        const totalCardWidth = carousel.scrollWidth;
        
        // Calculate the maximum scroll position
        const maxScrollLeft = totalCardWidth - carousel.offsetWidth;
        
        // If the carousel is at the end, stop autoplay
        if (carousel.scrollLeft >= maxScrollLeft) return;
        
        // Autoplay the carousel after every 2500ms
        timeoutId = setTimeout(() => 
            carousel.scrollLeft += firstCardWidth, 2500);
    };

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);
    wrapper.addEventListener("mouseenter", () => 
        clearTimeout(timeoutId));
    wrapper.addEventListener("mouseleave", autoPlay);

    // Add event listeners for the arrow buttons to 
    // scroll the carousel left and right
    arrowBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            carousel.scrollLeft += btn.id === "left" ? 
                -firstCardWidth : firstCardWidth;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Sample data for charts
    const chartData1 = [1, 2, 3, 4, 5]; // Data for chart 1
    const chartData2 = [5, 3, 4, 7, 2]; // Data for chart 2
    const chartData3 = [2, 3, 5, 1, 4]; // Data for chart 3
    const chartData4 = [3, 5, 2, 6, 4]; // Data for chart 4
    const chartData5 = [4, 3, 2, 5, 7]; // Data for chart 5
    const chartData6 = [2, 4, 1, 3, 5]; // Data for chart 6
    const chartData7 = [5, 2, 4, 1, 3]; // Data for chart 7
    const chartData8 = [1, 5, 3, 2, 4]; // Data for chart 8
    const chartData9 = [2, 1, 5, 4, 3]; // Data for chart 9

    // Colors for each chart
    const colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(153, 102, 255, 0.5)', 'rgba(255, 159, 64, 0.5)', 'rgba(201, 203, 207, 0.5)', 'rgba(255, 99, 71, 0.5)', 'rgba(0, 255, 255, 0.5)'];

    // Create charts
    Highcharts.chart('chart1', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 1',
            data: chartData1,
            color: colors[0] // Assign color for chart 1
        }]
    });

    Highcharts.chart('chart2', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 2',
            data: chartData2,
            color: colors[1] // Assign color for chart 2
        }]
    });

    Highcharts.chart('chart3', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 3',
            data: chartData3,
            color: colors[2] // Assign color for chart 3
        }]
    });

    Highcharts.chart('chart4', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 4',
            data: chartData4,
            color: colors[3] // Assign color for chart 4
        }]
    });

    Highcharts.chart('chart5', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 5',
            data: chartData5,
            color: colors[4] // Assign color for chart 5
        }]
    });

    Highcharts.chart('chart6', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 6',
            data: chartData6,
            color: colors[5] // Assign color for chart 6
        }]
    });

    Highcharts.chart('chart7', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 7',
            data: chartData7,
            color: colors[6] // Assign color for chart 7
        }]
    });

    Highcharts.chart('chart8', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 8',
            data: chartData8,
            color: colors[7] // Assign color for chart 8
        }]
    });

    Highcharts.chart('chart9', {
        chart: {
            type: 'area'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: ['A', 'B', 'C', 'D', 'E']
        },
        yAxis: {
            title: {
                text: 'Values'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Data Series 9',
            data: chartData9,
            color: colors[8] // Assign color for chart 9
        }]
    });
});
