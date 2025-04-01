@extends('Admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Welcome To Eatz AI Dashboard</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Home</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-body p-20">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="row g-3">
                            <div class="col-sm-6 col-xs-6">
                                <div class="radius-8 h-100 text-center p-20 bg-purple-light">
                                    <span
                                        class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-lilac-200 border border-lilac-400 text-lilac-600">
                                        <i class="ri-price-tag-3-fill"></i>
                                    </span>
                                    <span class="text-neutral-700 d-block">Total Sales</span>
                                    <h6 class="mb-0 mt-4">$170,500.09</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="radius-8 h-100 text-center p-20 bg-success-100">
                                    <span
                                        class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-success-200 border border-success-400 text-success-600">
                                        <i class="ri-shopping-cart-2-fill"></i>
                                    </span>
                                    <span class="text-neutral-700 d-block">Total Orders</span>
                                    <h6 class="mb-0 mt-4">1,500</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="radius-8 h-100 text-center p-20 bg-info-focus">
                                    <span
                                        class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-info-200 border border-info-400 text-info-600">
                                        <i class="ri-group-3-fill"></i>
                                    </span>
                                    <span class="text-neutral-700 d-block">Visitor</span>
                                    <h6 class="mb-0 mt-4">12,300</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="radius-8 h-100 text-center p-20 bg-danger-100">
                                    <span
                                        class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-xl mb-12 bg-danger-200 border border-danger-400 text-danger-600">
                                        <i class="ri-refund-2-line"></i>
                                    </span>
                                    <span class="text-neutral-700 d-block">Refunded</span>
                                    <h6 class="mb-0 mt-4">2756</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>


@endsection


@push('custom-scripts')

<script>
    // ===================== Revenue Chart Start =============================== 
    function createChartTwo(chartId, color1, color2) {
        var options = {
            series: [{
                name: 'Profit',
                data: [6, 20, 15, 48, 28, 55, 28, 52, 25, 32, 15, 25]
            }, {
                name: 'Loss',
                data: [0, 8, 4, 36, 16, 42, 16, 40, 12, 24, 4, 12]
            }],
            legend: {
                show: false
            },
            chart: {
                type: 'area',
                width: '100%',
                height: 150,
                toolbar: {
                    show: false
                },
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: [color1, color2], // Use two colors for the lines
                lineCap: 'round'
            },
            grid: {
                show: true,
                borderColor: '#D1D5DB',
                strokeDashArray: 1,
                position: 'back',
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                row: {
                    colors: undefined,
                    opacity: 0.5
                },
                column: {
                    colors: undefined,
                    opacity: 0.5
                },
                padding: {
                    top: -20,
                    right: 0,
                    bottom: -10,
                    left: 0
                },
            },
            colors: [color1, color2], // Set color for series
            fill: {
                type: 'gradient',
                colors: [color1, color2], // Use two colors for the gradient
                // gradient: {
                //     shade: 'light',
                //     type: 'vertical',
                //     shadeIntensity: 0.5,
                //     gradientToColors: [`${color1}`, `${color2}00`], // Bottom gradient colors with transparency
                //     inverseColors: false,
                //     opacityFrom: .6,
                //     opacityTo: 0.3,
                //     stops: [0, 100],
                // },
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: [undefined, `${color2}00`], // Apply transparency to both colors
                    inverseColors: false,
                    opacityFrom: [0.4, 0.6], // Starting opacity for both colors
                    opacityTo: [0.3, 0.3], // Ending opacity for both colors
                    stops: [0, 100],
                },
            },
            // markers: {
            //     colors: [color1, color2], // Use two colors for the markers
            //     strokeWidth: 3,
            //     size: 0,
            //     hover: {
            //         size: 10
            //     }
            // },

            markers: {
                colors: [color1, color2],
                strokeWidth: 2,
                size: 0,
                hover: {
                    size: 8
                }
            },

            xaxis: {
                labels: {
                    show: false
                },
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                tooltip: {
                    enabled: false
                },
                labels: {
                    formatter: function (value) {
                        return value;
                    },
                    style: {
                        fontSize: "14px"
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "$" + value + "k";
                    },
                    style: {
                        fontSize: "14px"
                    }
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
        chart.render();
    }

    createChartTwo('revenueChart', '#CD20F9', '#6593FF');
    // ===================== Revenue Chart End =============================== 

    // ================================ Bar chart Start ================================ 
    var options = {
        series: [{
            name: "Sales",
            data: [{
                x: 'Sun',
                y: 15,
            }, {
                x: 'Mon',
                y: 12,
            }, {
                x: 'Tue',
                y: 18,
            }, {
                x: 'Wed',
                y: 20,
            }, {
                x: 'Thu',
                y: 13,
            }, {
                x: 'Fri',
                y: 16,
            }, {
                x: 'Sat',
                y: 6,
            }]
        }],
        chart: {
            type: 'bar',
            height: 200,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                horizontal: false,
                columnWidth: 24,
                columnWidth: '40%',
                endingShape: 'rounded',
            }
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'gradient',
            colors: ['#dae5ff'], // Set the starting color (top color) here
            gradient: {
                shade: 'light', // Gradient shading type
                type: 'vertical', // Gradient direction (vertical)
                shadeIntensity: 0.5, // Intensity of the gradient shading
                gradientToColors: ['#dae5ff'], // Bottom gradient color (with transparency)
                inverseColors: false, // Do not invert colors
                opacityFrom: 1, // Starting opacity
                opacityTo: 1, // Ending opacity
                stops: [0, 100],
            },
        },
        grid: {
            show: false,
            borderColor: '#D1D5DB',
            strokeDashArray: 4, // Use a number for dashed style
            position: 'back',
            padding: {
                top: -10,
                right: -10,
                bottom: -10,
                left: -10
            }
        },
        xaxis: {
            type: 'category',
            categories: ['2hr', '4hr', '6hr', '8hr', '10hr', '12hr', '14hr']
        },
        yaxis: {
            show: false,
        },
    };

    var chart = new ApexCharts(document.querySelector("#barChart"), options);
    chart.render();
    // ================================ Bar chart End ================================ 

    // ================================ J Vector Map Start ================================ 
    $('#world-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        borderColor: '#fff',
        borderOpacity: 0.25,
        borderWidth: 0,
        color: '#000000',
        regionStyle: {
            initial: {
                fill: '#D1D5DB'
            }
        },
        markerStyle: {
            initial: {
                r: 5,
                'fill': '#fff',
                'fill-opacity': 1,
                'stroke': '#000',
                'stroke-width': 1,
                'stroke-opacity': 0.4
            },
        },
        markers: [{
                latLng: [35.8617, 104.1954],
                name: 'China : 250'
            },

            {
                latLng: [25.2744, 133.7751],
                name: 'AustrCalia : 250'
            },

            {
                latLng: [36.77, -119.41],
                name: 'USA : 82%'
            },

            {
                latLng: [55.37, -3.41],
                name: 'UK   : 250'
            },

            {
                latLng: [25.20, 55.27],
                name: 'UAE : 250'
            }
        ],

        series: {
            regions: [{
                values: {
                    "US": '#487FFF ',
                    "SA": '#487FFF',
                    "AU": '#487FFF',
                    "CN": '#487FFF',
                    "GB": '#487FFF',
                },
                attribute: 'fill'
            }]
        },
        hoverOpacity: null,
        normalizeFunction: 'linear',
        zoomOnScroll: false,
        scaleColors: ['#000000', '#000000'],
        selectedColor: '#000000',
        selectedRegions: [],
        enableZoom: false,
        hoverColor: '#fff',
    });
    // ================================ J Vector Map End ================================ 


    // ================================ Users Overview Donut chart Start ================================ 
    var options = {
        series: [500, 500, 500],
        colors: ['#FF9F29', '#487FFF', '#45B369'],
        labels: ['Active', 'New', 'Total'],
        legend: {
            show: false
        },
        chart: {
            type: 'donut',
            height: 270,
            sparkline: {
                enabled: true // Remove whitespace
            },
            margin: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            }
        },
        stroke: {
            width: 0,
        },
        dataLabels: {
            enabled: false
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
    };

    var chart = new ApexCharts(document.querySelector("#userOverviewDonutChart"), options);
    chart.render();
    // ================================ Users Overview Donut chart End ================================ 

</script>

@endpush
