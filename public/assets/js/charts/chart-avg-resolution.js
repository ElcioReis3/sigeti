var optionsAvgResolution = {
    series: [
        {
            name: "Dias",
            data: window.dashboardData.avgResolutionDays,
        },
    ],
    chart: {
        height: 350,
        type: "line",
        toolbar: { show: false },
        zoom: { enabled: false },
    },
    dataLabels: { enabled: false },
    stroke: {
        curve: "smooth",
        width: 3,
    },
    colors: ["#435ebe"],
    markers: {
        size: 4,
    },
    xaxis: {
        categories: [
            "Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
            "Jul", "Ago", "Set", "Out", "Nov", "Dez"
        ],
    },
    yaxis: {
        title: {
            text: "Dias",
        },
        min: 0,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " dia(s)"
            },
        },
    },
}

var chartAvgResolution = new ApexCharts(
    document.querySelector("#chart-avg-resolution"),
    optionsAvgResolution
)
chartAvgResolution.render()