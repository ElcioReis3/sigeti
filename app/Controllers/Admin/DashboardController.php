<?php

namespace App\Controllers\Admin;

use App\Core\AbstractModel;
use App\Core\Auth;

class DashboardController extends AbstractModel
{
    public function __construct()
    {
        parent::__construct("App");

    }

    public function index(): void
    {
        $totalUsers = 0;
        $totalDepartments = 0;
        $totalOpenTickets = 0;
        echo $this->view->render("admin/dashboard", [
            "totalUsers" => $totalUsers,
            "totalDepartments" => $totalDepartments,
            "totalOpenTickets" => $totalOpenTickets
        ]);
    }
}