console.log(window.dashboardData)

var optionsTicketsByMonth = {
    annotations: {position: "back"},
    dataLabels: {enabled: false},
    chart: {
        type: "bar",
        height: 300,
    },
    fill: {opacity: 1},
    plotOptions: {},
    series: [
        {
            name: "Chamados",
            data: window.dashboardData.quantityTicketsByMonth,
        },
    ],
    colors: "#435ebe",
    xaxis: {
        categories: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    },
}

var chartTicketsMonth = new ApexCharts(
    document.querySelector("#chart-tickets-month"),
    optionsTicketsByMonth
)

chartTicketsMonth.render()
