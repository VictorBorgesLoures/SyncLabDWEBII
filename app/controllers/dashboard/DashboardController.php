<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\classes\Enviromment;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\controllers\Controller;

class DashboardController extends Controller {

    public function viewDashboard(): void
    {
        $totalProjetos = 3;
        $totalAtividades = 4;

        Session::verifyLogin();

        // Verificar a logica do dashboard ... Como será para o admin, docente e discente
        if(Session::get('type') == 'admin'){
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "totalAtividades" => $totalAtividades
            ]);
        }
        else if(Session::get('type') == 'docente'){
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "totalAtividades" => $totalAtividades
            ]);
        }
        else{
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "totalAtividades" => $totalAtividades
            ]);
        }


    }




}