<?php

namespace cefet\SyncLab\controllers\dashboard;
use cefet\SyncLab\classes\Projeto;
use cefet\SyncLab\classes\User;
use cefet\SyncLab\classes\Session;
use cefet\SyncLab\controllers\Controller;

class DashboardController extends Controller {
    
    private $user;
    private $project;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->project = new Projeto();
    }

    public function viewDashboard(): void
    {
        //var_dump(Session::dump());
        $totalProjetos = count($this->project->getProjetosAtivos(Session::get('idMat')));
        $atvEmAndamento = count($this->project->getAtividadesEmAndamento(Session::get('idMat')));
        $atvConcluidas = count($this->project->getAtividadesRealizadas(Session::get('idMat')));

        if(Session::get('type') == 'admin'){
            $totalReqMat = $this->user->getTotalRequisicoesMatConcluidas();
            $totalReqProj = $this->user->getTotalRequisicoesProjConcluidas();
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "atvConcluidas" => $atvConcluidas,
                "atvEmAndamento" => $atvEmAndamento,
                "totalReqMat" => $totalReqMat,
                "totalReqProj" => $totalReqProj,
            ]);
        }
        else if(Session::get('type') == 'docente'){
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "atvConcluidas" => $atvConcluidas,
                "atvEmAndamento" => $atvEmAndamento,
            ]);
        }
        else{
            $this->view("dashboard/dashboard", [
                "totalProjetos" => $totalProjetos,
                "atvConcluidas" => $atvConcluidas,
                "atvEmAndamento" => $atvEmAndamento,
            ]);
        }
    }

    public function gerarGrafico(): void
    {
        header('Content-Type: application/json');
        $projeto = [
            'id' => 'proj',
            'label' => '# de Projetos Ativos',
            'data' => $this->project->getProjetosMes(Session::get('idMat')),
            'borderColor' => 'rgb(75, 192, 192)',
            'borderWidth' => 1
        ];

        $atv = [
            'id' => 'atv',
            'label' => '# de Atividades Realizadas',
            'data' => $this->project->getAtividadesMes(Session::get('idMat')),
            'borderColor' => 'rgb(75, 2, 3)',
            'borderWidth' => 1
        ];
        $req = [
            'id' => 'req',
            'label' => '# de Requisições Concluídas',
            'data' => $this->user->getRequisicoesMes(),
            'borderColor' => 'rgb(2, 4, 66)',
            'borderWidth' => 1
        ];

        echo json_encode(['datasetProjeto' => $projeto, 'datasetAtividade' => $atv, 'datasetRequisicoes' => $req]);

    }

}