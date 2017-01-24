<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->set('title_for_layout', 'Painel Administrativo');
    }
}
