var data = window.dashboardData.ticketsByPriorityAndStatus;

var statusLabels = [
    "Aberto",
    "Em Andamento",
    "Aguardando",
    "Resolvido",
    "Finalizado",
    "Arquivado"
];

var statusKeys = [
    "aberto",
    "em_andamento",
    "aguardando",
    "resolvido",
    "finalizado",
    "arquivado"
];

var optionsTicketsPriority = {
    series: [
        {
            name: "Baixa",
            data: statusKeys.map(function (s) { return data.baixa[s]; }),
        },
        {
            name: "Média",
            data: statusKeys.map(function (s) { return data.media[s]; }),
        },
        {
            name: "Alta",
            data: statusKeys.map(function (s) { return data.alta[s]; }),
        },
    ],
    chart: {
        type: "bar",
        height: 350,
        toolbar: { show: false },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
        },
    },
    dataLabels: { enabled: false },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    colors: ["#6c757d", "#435ebe", "#dc3545"],
    xaxis: {
        categories: statusLabels,
    },
    yaxis: {
        title: { text: "Chamados" },
        min: 0,
    },
    fill: { opacity: 1 },
    tooltip: {
        y: {
            formatter: function (val) {
                return val + " chamado(s)"
            },
        },
    },
    legend: {
        position: "top",
    },
}

var chartTicketsPriority = new ApexCharts(
    document.querySelector("#chart-tickets-priority"),
    optionsTicketsPriority
)
chartTicketsPriority.render()