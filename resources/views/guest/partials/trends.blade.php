    @php 
        $pieData = getPieChartData();
        $splineData = getSplineChartData();
    @endphp
    <h4>Trends</h4>
    <p>Most Searched Locations in DHA <span class="badge bg-accent">{{date('M Y')}} </span></p>
    <!-- Highcharts Containers added by Hamza Amjads-->
    <div class="charts-container">
        <div id="userSearchesTrend" class="chart-container"></div>
        <div id="locationWiseSearchesTrend" class="chart-container"></div>
    </div>
    <style>
        /* Container for the charts */
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .chart-container {
            flex: 1;
            min-width: 300px;
            max-width: 100%;
        }

        /* Large screen: show large iframe, hide small iframe */
        .iframe-large {
            display: block;
        }

        .iframe-small {
            display: none;
        }

        /* Small screen: show small iframe, hide large iframe */
        @media (max-width: 860px) {
            .iframe-large {
                display: none;
            }

            .iframe-small {
                display: block;
                width: 100%;
                height: 680px !important;
            }
        }
    </style>
    {{-- Highchart added by Hamza Amjad --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const originalData = @json($splineData); // Store the original data when the chart loads
            let previousSearchCount = null; // Variable to track the last data point
            let repeatCount = 0; // Track the number of times the same value is repeated
            const maxRepeatsAllowed = 3; // Set how many times repeated values are allowed before restarting

            const chart = Highcharts.chart('userSearchesTrend', {
                chart: {
                    type: 'spline',
                    events: {
                        load: function() {
                            const series = this.series[0];
                            // Fetch data at regular intervals
                            setInterval(function() {
                                fetchSearchData(series);
                            }, 1000); // Fetch every second
                        },
                        redraw: function() {
                            console.log('Chart has been redrawn'); // For debugging, log when the chart redraws
                        }
                    }
                },
                title: {
                    text: 'User Searches Trend'
                },
                xAxis: {
                    type: 'datetime',
                    title: {
                        text: '' // X-axis text removed
                    },
                    tickPixelInterval: 150
                },
                yAxis: {
                    title: {
                        text: 'Number of Searches'
                    },
                    min: 0
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Searches',
                    data: originalData // Initialize the chart with the original data
                }],
                plotOptions: {
                    spline: {
                        dataLabels: {
                            enabled: true
                        },
                        marker: {
                            enabled: false
                        },
                        lineWidth: 2
                    }
                }
            });

            // Function to fetch search logs from the server for live updates
            function fetchSearchData(series) {
                fetch('/fetchLatestSearchCount')
                    .then(response => response.json())
                    .then(data => {
                        const x = (new Date()).getTime(); // Current time for X-axis
                        const y = data.searchCount; // The new search count

                        // Check if the new data is repeated
                        if (y === previousSearchCount) {
                            repeatCount++; // Increment repeat count
                            if (repeatCount >= maxRepeatsAllowed) {
                                // Reset the chart's series when the same value repeats too often
                                series.setData(originalData, true); // Reset the series data
                                repeatCount = 0; // Reset the repeat count
                            }
                        } else {
                            // Add the new data point if the value is different
                            series.addPoint([x, y], true, true);
                            repeatCount = 0; // Reset repeat count
                        }

                        previousSearchCount = y; // Update the previous search count
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }


            // Location Wise Searches Trend Chart
            function createOrUpdateChart() 
            {
                if (window.locationWiseChart) {
                    window.locationWiseChart.destroy();
                }

                var locationWiseData = @json($pieData);

                window.locationWiseChart = Highcharts.chart('locationWiseSearchesTrend', {
                    chart: {
                        type: 'pie',
                        animation: {
                            duration: 1000,
                            easing: 'easeOutBounce'
                        }
                    },
                    title: {
                        text: 'Location Wise Searches Trend'
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Searches',
                        data: locationWiseData,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.percentage:.1f} %'
                        }
                    }],
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.1f} %'
                            }
                        }
                    }
                });
            }

            createOrUpdateChart();

            // Intersection Observer to refresh the pie chart when in view
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        createOrUpdateChart();
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            observer.observe(document.getElementById('locationWiseSearchesTrend'));
        });
    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>