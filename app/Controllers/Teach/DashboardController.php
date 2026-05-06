<?php

namespace App\Controllers\Teach;

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

        Auth::requirePermission(Permission::VIEW_REQUESTER_DASHBOARD);
    }

    public function index(): void
    {
        $ticketModel = new Ticket();
        $userId = Auth::user()->id;

        $tickets = (new Ticket())->ticketsOrderedByStatusPriorityAndOpeningDateByUser(Auth::user()->id);
        $quantityTicketsByStatus = $ticketModel->countTicketsByStatus($userId,);
        $quantityTicketsByMonth = $ticketModel->countTicketsByMonth($userId);
        $quantityTicketsByCategory = $ticketModel->countTicketsByCategory($userId);

        echo $this->view->render("teach/dashboard", [

            "tickets" => $tickets,
            "quantityTicketsByStatus" => $quantityTicketsByStatus,
            "quantityTicketsByMonth" => $quantityTicketsByMonth,
            "quantityTicketsByCategory" => $quantityTicketsByCategory,
        ]);
    }
}