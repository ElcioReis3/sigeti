<?php

namespace App\Controllers\Technician;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\Ticket\Ticket;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::VIEW_TECHNICIAN_DASHBOARD);
    }

    public function index(): void
    {
        $ticketModel = new Ticket();

        echo $this->view->render("technician/dashboard", [
            "tickets" => $ticketModel->allOrdered(),
            "quantityTicketsByStatus" => $ticketModel->countByStatusCurrentYear(),
            "quantityTicketsByMonth" => $ticketModel->countByMonthCurrentYear(),
            "quantityTicketsByCategory" => $ticketModel->countByCategoryCurrentYear(),
            "resolutionRate" => $ticketModel->resolutionRateCurrentYear(),
            "avgResolutionDays" => $ticketModel->avgResolutionDaysByMonthCurrentYear(),
            "ticketsByPriorityAndStatus" => $ticketModel->countByPriorityAndStatusCurrentYear(),
        ]);
    }
}