// Limit speedometer chart of properties added by Hamza Amjad
document.addEventListener('DOMContentLoaded', function () {
    var total = $('#totalProperties').text() != '' ? parseInt($('#totalProperties').text()) : 0;
    var consumed = $('#consumed').text() != '' ? [parseInt($('#consumed').text())] : [0];
    Highcharts.chart('speedometer-container', {
        chart: {
            type: 'solidgauge'
        },
        title: {
            text: 'Limit of adding Properties',
            style: {
                fontSize: '24px'
            }
        },
        pane: {
            startAngle: -100,
            endAngle: 100,
            background: [{
                outerRadius: '112%',
                innerRadius: '88%',
                backgroundColor: Highcharts.color(Highcharts.getOptions().colors[10]).setOpacity(0.3).get(),
                borderWidth: 0
            }]
        },
        credits: {
            enabled: false
        },
        yAxis: {
            min: 0,
            max: total,
            stops: [
                [0.1, '#28a745'], // green
                [0.6, '#ffc107'], // yellow
                [0.9, '#df5353']  // red
            ],
            lineWidth: 0,
            tickInterval: 1,
            minorTickInterval: null,
            tickWidth: 0,
            labels: {
                y: 16
            }
        },
        series: [{
            name: 'Properties Added',
            data: consumed, // Dummy data
            tooltip: {
                valueSuffix: ' Total'
            },
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px">{y}</span><br/>' +
                    '<span style="font-size:12px;opacity:0.4;text-align:center;">Total added</span></div>'
            }
        }],
        tooltip: {
            formatter: function () {
                // Dummy DateTime when the property was added.
                /* let dateAdded = new Date().toLocaleString();  */
                return `Properties Added: <strong>${this.y}</strong>`; /* <br>Date Added: <strong>${dateAdded}</strong> */
            }
        }
    });
});