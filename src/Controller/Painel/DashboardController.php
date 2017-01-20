<?php
namespace App\Controller\Painel;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->set('title_for_layout', 'Painel Administrativo');
    }
}
