<?php

namespace App\Controllers\Technical;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_TECHNICAL_DASHBOARD);
    }

    public function index(): void
    {
        $ticketModel = new Ticket();
        $tickets = (new Ticket())->ticketsOrderedByStatusPriorityAndOpeningDate();

        $quantityTicketsByMonth = $ticketModel->countTicketsByMonth(null, 2024);
        $quantityTicketsByCategory = $ticketModel->countTicketsByCategory(null,2024);
        $quantityTicketsByStatus = $ticketModel->countTicketsByStatus(null, 2024);

        $avgResolutionDays = $ticketModel->avgResolutionDaysByMonthCurrentYear( 2024);
        $ticketsByPriorityAndStatus = $ticketModel->countByPriorityAndStatusCurrentYear( 2024);

        echo $this->view->render("technical/dashboard", [
            "tickets" => $tickets,
            "quantityTicketsByMonth" => $quantityTicketsByMonth,
            "quantityTicketsByCategory" => $quantityTicketsByCategory,
            "quantityTicketsByStatus" => $quantityTicketsByStatus,

            "avgResolutionDays" => $avgResolutionDays,
            "ticketsByPriorityAndStatus" => $ticketsByPriorityAndStatus,
        ]);
    }
}