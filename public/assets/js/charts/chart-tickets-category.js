var categoryData = window.dashboardData?.quantityTicketsByCategory || {
    labels: [],
    totals: []
};

if (!categoryData.labels.length) {
    console.warn("Sem dados para gráfico de categorias");
} else {

    var colors = [
        "#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b",
        "#858796", "#5a5c69", "#2e59d9", "#17a673", "#2c9faf"
    ].slice(0, categoryData.labels.length);

    var optionsTicketsByCategory = {
        series: categoryData.totals,
        chart: {
            type: "pie",
            height: 337
        },
        labels: categoryData.labels,
        colors: colors,
        legend: {
            position: "bottom"
        },
        dataLabels: {
            enabled: true
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " chamado(s)";
                }
            }
        }
    };

    var el = document.querySelector("#chart-tickets-category");

    if (el) {
        var chart = new ApexCharts(el, optionsTicketsByCategory);
        chart.render();
    }
}