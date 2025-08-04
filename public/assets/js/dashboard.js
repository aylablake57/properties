document.addEventListener("DOMContentLoaded", () => {
    drawLineChart('this month');

    /* $.ajax({
        url: "../recentComplaints",
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {},
        success: function(data) {
            new DataTable('#recentComplaints', {
                pageResize: true,
                "lengthMenu": [ 5 , 10, 15 , 25 ],
                data: data,
                columns: [
                    { "data": "no" },
                    { "data": "category" },
                    { "data": "followup_name" },
                    { "data": "time"},
                    { "data": "status" }
                ]
            });
        },
        error: function(response) {
            console.log(response);
        }
    }); */

    /* $.ajax({
        url: "../recentNews",
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {},
        success: function(data) {
            $('.news').empty();
            $('.news').append(data.html_data);
        },
        error: function(response) {
            console.log(response);
        }
    }); */

    /* $.ajax({
        url: "../recentActivity",
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {},
        success: function(data) {
            $('.activity').empty();
            $('.activity').append(data.html_data);
        },
        error: function(response) {
            console.log(response);
        }
    }); */
});

document.addEventListener("DOMContentLoaded", () => {
    $.ajax({
        url: "../admin/registrationChart", 
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {},
        success: function(data) {
            const chart = Highcharts.chart('registrationChart', {
                title: {
                    text: ""
                },
                colors: [
                    '#7171fc', '#18d26e', '#ff771d', '#48c6ef', 'yellow', 'pink', 
                    '#0dd9db', '#03dfd0', '#00e4c5', '#00e9ba', '#00eeaf', '#23e274'
                ],
                xAxis: {
                    categories: data.categories // Categories from database (e.g., months)
                },
                yAxis: {
                    title:""
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        type:'column',
                        name: 'Sellers Total',
                        group: 'Total',
                        data: data.sellerTotal
                    },
                    {
                        type:'column',
                        name: 'Sellers Verified',
                        group: 'Verified',
                        data: data.sellerVerified
                    },
                    {
                        type:'column',
                        name: 'Agents Total',
                        group: 'total',
                        data: data.agentTotal
                    },
                    {
                        type:'column',
                        name: 'Agents Verified',
                        group: 'verified',
                        data: data.agentVerified
                    },
                    {
                        type:'column',
                        name: 'Agency Total',
                        group: 'total',
                        data: data.agencyTotal
                    },
                    {
                         type:'column',
                        name: 'Agency Verified',
                        group: 'verified',
                        data: data.agencyVerified
                    }
                ],
            });

            // Event listeners for updating the chart type
            document.getElementById('plain').addEventListener('click', () => {
                chart.update({
                    chart: {
                        inverted: false,
                        polar: false
                    },
                });
            });

            document.getElementById('inverted').addEventListener('click', () => {
                chart.update({
                    chart: {
                        inverted: true,
                        polar: false
                    },
                });
            });

            document.getElementById('polar').addEventListener('click', () => {
                chart.update({
                    chart: {
                        inverted: false,
                        polar: true
                    },
                });
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
});


// document.addEventListener("DOMContentLoaded", () => {
//     $.ajax({
//         url: "../admin/registrationChart",
//         type: "POST",
//         dataType: "JSON",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {},
//         success: function(data) {
//             var options = {
//                 series: [
//                     {
//                         name: 'Sellers Total',
//                         group: 'Total',
//                         data: data.sellerTotal
//                     },
//                     {
//                         name: 'Sellers Verified',
//                         group: 'Verified',
//                         data: data.sellerVerified
//                     },
//                     {
//                         name: 'Agents Total',
//                         group: 'total',
//                         data: data.agentTotal
//                     },
//                     {
//                         name: 'Agents Verified',
//                         group: 'verified',
//                         data: data.agentVerified
//                     },
//                     {
//                         name: 'Agency Total',
//                         group: 'total',
//                         data: data.agencyTotal
//                     },
//                     {
//                         name: 'Agency Verified',
//                         group: 'verified',
//                         data: data.agencyVerified
//                     }
//                 ],
//                 chart: {
//                     type: 'bar',
//                     height: 350,
//                     stacked: true,
//                 },
//                 stroke: {
//                     width: 1,
//                     colors: ['#fff']
//                 },
//                 dataLabels: {
//                     formatter: (val) => {
//                         return val/*  / 1000 + 'K' */
//                     }
//                 },
//                 plotOptions: {
//                     bar: {
//                         horizontal: false
//                     }
//                 },
//                 xaxis: {
//                     categories: data.categories
//                 },
//                 fill: {
//                     opacity: 1
//                 },
//                 colors: ['#80c7fd', '#008FFB', '#80f1cb', '#00E396' , '#ff771d' , '#ffb01d'],
//                 yaxis: {
//                     labels: {
//                         formatter: (val) => {
//                             return val/*  / 1000 + 'K' */
//                         }
//                     }
//                 },
//                 legend: {
//                     position: 'top',
//                     horizontalAlign: 'left'
//                 }
//             };

//             var chart = new ApexCharts(document.querySelector("#registrationChart"), options);
//             chart.render();
//         },
//         error: function(response) {
//             console.log(response);
//         }
//     });

// });

document.addEventListener("DOMContentLoaded", () => {
    $.ajax({
        url: "../admin/trafficReport",
        type: "POST",
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {},
        success: function(data) {
            // Transforming the data for Highcharts
            const chartData = data.map(item => ({
                name: item.name, // Assuming 'name' is the label in your data
                y: item.value    // Assuming 'value' is the count in your data
            }));

            // Initialize the Highcharts pie chart with the updated style
            Highcharts.chart('signupChart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: null
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>' // Show total number
                },
                accessibility: {
                    point: {
                        valueSuffix: '' // No suffix for total
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true, // Enable data labels to show total numbers
                            format: '<b>{point.name}</b>: {point.y}' // Format to show total numbers
                        },
                        showInLegend: true // Show legend
                    }
                },
                series: [{
                    name: 'Login Type',
                    colorByPoint: true,
                    data: chartData // Use the original chart data
                }],
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    floating: false,
                    y: 10, // Adjust this value for spacing from the chart
                    itemMarginTop: 5,
                    itemMarginBottom: 5,
                    labelFormatter: function() {
                        return `<b>${this.name}</b>`; // Custom label format
                    }
                }
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
});

//one more column add in filters filter_type

const filters = {
    '#filterTotalToday': ['total', 'today', '#section-total', 'property'],
    '#filterTotalMonth': ['total', 'last_month', '#section-total', 'property'],
    '#filterTotalYear': ['total', 'this_year', '#section-total', 'property'],
    '#filterApprovedToday': ['Approved', 'today', '#section-approved', 'property'],
    '#filterApprovedMonth': ['Approved', 'last_month', '#section-approved', 'property'],
    '#filterApprovedYear': ['Approved', 'this_year', '#section-approved', 'property'],
    '#filterCancelToday': ['Cancel', 'today', '#section-cancel', 'property'],
    '#filterCancelMonth': ['Cancel', 'last_month', '#section-cancel', 'property'],
    '#filterCancelYear': ['Cancel', 'this_year', '#section-cancel', 'property'],
    '#filterSoldToday': ['Sold', 'today', '#section-sold', 'property'],
    '#filterSoldMonth': ['Sold', 'last_month', '#section-sold', 'property'],
    '#filterSoldYear': ['Sold', 'this_year', '#section-sold', 'property'],
    // Ads
    '#adFilterTotalToday': ['total', 'today', '#ad-section-total', 'ad'],
    '#adFilterTotalMonth': ['total', 'last_month', '#ad-section-total', 'ad'],
    '#adFilterTotalYear': ['total', 'this_year', '#ad-section-total', 'ad'],
    '#adFilterApprovedToday': ['Approved', 'today', '#ad-section-approved', 'ad'],
    '#adFilterApprovedMonth': ['Approved', 'last_month', '#ad-section-approved', 'ad'],
    '#adFilterApprovedYear': ['Approved', 'this_year', '#sad-ection-approved', 'ad'],
    '#adFilterCancelToday': ['Cancel', 'today', '#ad-section-cancel', 'ad'],
    '#adFilterCancelMonth': ['Cancel', 'last_month', '#ad-section-cancel', 'ad'],
    '#adFilterCancelYear': ['Cancel', 'this_year', '#ad-section-cancel', 'ad'],
    '#adFilterExpiredToday': ['Expired', 'today', '#ad-section-expired', 'ad'],
    '#adFilterExpiredMonth': ['Expired', 'last_month', '#ad-section-expired', 'ad'],
    '#adFilterExpiredYear': ['Expired', 'this_year', '#ad-section-expired', 'ad'],
    // '#adFilterSoldToday': ['Sold', 'today', '#section-sold', 'ad'],
    // '#adFilterSoldMonth': ['Sold', 'last_month', '#section-sold', 'ad'],
    // '#adFilterSoldYear': ['Sold', 'this_year', '#section-sold', 'ad'],

};

const durationText = {
    'today': 'Today',
    'last_month': 'Last Month',
    'this_year': 'This Year'
};

$.each(filters, function(id, filter) {
    $(document).on('click', id, function() {
        getFilters(filter[0], filter[1], filter[2], filter[3]); // Pass the section identifier
    });
});

function getFilters(type, duration, sectionId, filterType) {
    $.ajax({
        type: 'GET',
        url: '/admin/filter',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { type, duration, filterType },
        success: function(data) {
            let elementId = type === 'total' ? '#totalProperties' : type === 'Approved' ? '#approvedProperties' : type==='Sold' ? '#soldProperties' : '#cancelledProperties';
            $(`${sectionId} ${elementId}`).html(data.count);
            
            let title = type === 'total' ? 'Total' : capitalizeFirstLetter(type);
            $(`${sectionId} .card-title`).html(`${title} <span>| ${durationText[duration]}</span>`);
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function drawLineChart(duration)
{
    $('#reportsChart').html('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "../admin/lineChart",
        data: {
            duration: duration
        },
        success: function(data){
            var obj = jQuery.parseJSON(data);

            if (duration == 'last month') {
                $('#linChart').find('span').html('/Last Month');
            } else if (duration == 'year') {
                $('#linChart').find('span').html('/This Year');
            } else {
                $('#linChart').find('span').html('/This Month');
            }

            // Clear the chart container
            $('#reportsChart').empty();

            // Highcharts chart configuration
            Highcharts.chart('reportsChart', {
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: obj.categories, 
                    labels: {
                        format: '{value}' // To display the month name
                    }
                },
                yAxis: {
                    title: {
                        text: null
                    }
                },
                tooltip: {
                    shared: true,
                    xDateFormat: '%B %Y',
                    headerFormat: '<b>{point.x}</b><br>'
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.5
                    }
                },
                series: [{
                    name: 'Total',
                    data: obj.totalValues,
                    color:'#7171fc'
                }, {
                    name: 'Approved',
                    data: obj.totalApproved,
                    color:'#18d26e'
                }, {
                    name: 'Canceled',
                    data: obj.totalCancel,
                    color:'#ff771d'
                },
                {
                    name: 'Sold',
                    data: obj.totalSold,
                    color:'#48c6ef'
                }]
            });

        },
        error: function(response) {
            $('#reportsChart').empty();
            console.log(response);
        }
    });
}

// Highchart1 added by Hamza Amjad
document.addEventListener("DOMContentLoaded", () => {
    drawHighChart();
});

function drawHighChart() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "../admin/lineChart",
        data: {
            duration: 'this month'
        },
        success: function(data){
            
            var obj = jQuery.parseJSON(data);
            //console.log(obj.new);
            Highcharts.chart('containerHighChart', {
                title: {
                    text: null,
                    align: 'left'
                },
                xAxis: {
                    categories: ['2020', '2021', '2022', '2023', '2024'], // Update years
                    title: {
                        text: 'Years'
                    }
                },
                credits: {
                    enabled: false
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    max: 250, 
                    tickAmount: 6, 
                    labels: {
                        formatter: function() {
                            return Math.floor(this.value); 
                        }
                    }
                },
                plotOptions: {
                    series: {
                        borderRadius: '25%'
                    }
                },
                series: obj.series /* [{
                    type: 'column',
                    name: 'DHAI-R',
                    data: [59, 24, 58, 65, 70] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Lahore',
                    data: [83, 79, 88, 92, 100] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Karachi',
                    data: [65, 72, 75, 80, 85] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Multan',
                    data: [228, 240, 250, 260, 270] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Peshawar',
                    data: [184, 167, 176, 180, 190] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Bahawalpur',
                    data: [90, 105, 120, 130, 140] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Gujranwala',
                    data: [110, 130, 140, 150, 160] // Update data for 2020 to 2024
                }, {
                    type: 'column',
                    name: 'DHA Quetta',
                    data: [77, 95, 100, 110, 120] // Update data for 2020 to 2024
                }, {
                    type: 'line',
                    step: 'center',
                    name: 'Average',
                    data: [47, 83.33, 70.66, 85, 100], // Update average data for 2020 to 2024
                    marker: {
                        lineWidth: 2,
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }] */
            });

        },
        error: function(response) {
            $('#reportsChart').empty();
            console.log(response);
        }
    });

    
}
// {
//     type: 'pie',
//     name: 'Total',
//     data: [{
//         name: '2020',
//         y: 619,
//         color: Highcharts.getOptions().colors[0],
//         dataLabels: {
//             enabled: true,
//             distance: -50,
//             format: 'years',
//             style: {
//                 fontSize: '15px'
//             }
//         }
//     }, {
//         name: '2021',
//         y: 586,
//         color: Highcharts.getOptions().colors[1]
//     }, {
//         name: '2022',
//         y: 647,
//         color: Highcharts.getOptions().colors[2]
//     }],
//     center: [75, 65],
//     size: 100,
//     innerSize: '70%',
//     showInLegend: false,
//     dataLabels: {
//         enabled: false
//     }
// }
// high chart 2
document.addEventListener("DOMContentLoaded", () => {
    fetchChartDataAndDraw();
});

function fetchChartDataAndDraw() {
    $.ajax({
        type: 'POST',
        url: "../admin/lineChart",
        data: {
            duration: 'year' // Or other duration as needed
        },
        success: function(data) {
            var obj = jQuery.parseJSON(data);

            // Prepare categories and series data for Highcharts
            var categories = obj.categories;
            var totalValues = obj.totalValues;
            var totalApproved = obj.totalApproved;
            var totalCancel = obj.totalCancel;

            // Log data to ensure it's correct
            console.log('Categories:', categories);
            console.log('Total Values:', totalValues);
            console.log('Total Approved:', totalApproved);
            console.log('Total Cancel:', totalCancel);

            var averageData = calculateAverage(totalValues, totalApproved, totalCancel);
            console.log('Average Data:', averageData);

            Highcharts.chart('container', {
                title: {
                    text: null,
                    align: 'left'
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    tickAmount: 6,
                    labels: {
                        formatter: function() {
                            return Math.floor(this.value); // Round down values for labels
                        }
                    }
                },
                plotOptions: {
                    series: {
                        borderRadius: '25%'
                    }
                },
                series: [{
                    type: 'column',
                    name: 'Total',
                    data: obj.totalValues,
                    color:'#7171fc'
                }, {
                    type: 'column',
                    name: 'Approved',
                    data: obj.totalApproved,
                    color:'#18d26e'
                }, {
                    type: 'column',
                    name: 'Canceled',
                    data: obj.totalCancel,
                    color:'#ff771d'
                },
                {
                    type: 'column',
                    name: 'Sold',
                    data: obj.totalSold,
                    color:'#48c6ef'
                }, {
                    type: 'line',
                    step: 'center',
                    name: 'Average',
                    color:'yellow',
                    data: averageData,
                    marker: {
                        lineWidth: 2,
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }]
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function calculateAverage(totalValues, totalApproved, totalCancel) {
    // Ensure arrays are of the same length
    var length = Math.min(totalValues.length, totalApproved.length, totalCancel.length);
    return totalValues.slice(0, length).map((value, index) => {
        return (value + totalApproved[index] + totalCancel[index]) / 3;
    });
}

function showChart(period) {
    document.getElementById('timePeriod').innerText = '/' + period.charAt(0).toUpperCase() + period.slice(1);
    
    // Toggle between charts
    if (period === 'year') {
        document.getElementById('containerHighChart').style.display = 'block';
        document.getElementById('container').style.display = 'none';
    } else {
        document.getElementById('container').style.display = 'block';
        document.getElementById('containerHighChart').style.display = 'none';
    }
}

// $("#filterToday").keyup()
