<?php

return [
    'get' => [
        //Home
        getenv("DOM_URI") => fn() => self::load('HomeController', 'viewHome'),
        getenv("DOM_URI") . 'contato' => fn() => self::load('HomeController', 'viewContato'),
        getenv("DOM_URI") . 'sobre' => fn() => self::load('HomeController', 'viewSobre'),
        getenv("DOM_URI") . 'saiba-mais' => fn() => self::load('HomeController', 'viewSaibaMais'),
        getenv("DOM_URI") . 'login' => fn() => self::load('LoginController', 'viewLogin'),
        getenv("DOM_URI") . 'matricula' => fn() => self::load('MatriculaController', 'viewMatricula'),
        getenv("DOM_URI") . 'matricula/requisitar' => fn() => self::load('RequisitarController', 'viewRequisitarMatricula'),
        getenv("DOM_URI") . 'dashboard' => fn() => self::load('DashboardController', 'viewDashboard'),
        getenv("DOM_URI") . 'registrar' => fn() => self::load('RegistrarController', 'viewRegistrar'),

        //errors
        getenv("DOM_URI") . 'error' => fn() => self::load('ErrorSystemController', 'index'),
        getenv("DOM_URI") . 'error404' => fn() => self::load('ErrorRouteController', 'index'),
        getenv("DOM_URI") . 'error-privilegio' => fn() => self::load('ErrorPrivilegioController', 'index'),


        //Projetos
        getenv("DOM_URI") . 'projetos' => fn() => self::load('ProjetosController', 'viewProjetos'),
        getenv("DOM_URI") . 'projetos/{id}' => fn($id) => self::load('ProjetosController', 'viewProjeto', $id),
        getenv("DOM_URI") . 'projetos/{id}/atividades' => fn($id) => self::load('AcoesController', 'viewAtividadesProj', $id),

        //Requisições deve-se remover as requisicoes
        getenv("DOM_URI") . 'requisicoes' => fn() => self::load('RequisicoesController', 'viewRequisicoes'),
        getenv("DOM_URI") . 'requisicoes/projeto' => fn() => self::load('RequisicoesProjetosController', 'viewReqProjetos'),
        getenv("DOM_URI") . 'requisicoes/matricula' => fn() => self::load('RequisicoesMatriculasController', 'viewReqMatriculas'),

        //Ações
        getenv("DOM_URI") . 'atividades' => fn() => self::load('AcoesController', 'viewAtividades'),
        getenv("DOM_URI") . 'atividades/{id}' => fn($id) => self::load('AcoesController', 'viewAtividade', $id),

        //Laboratórios
        getenv("DOM_URI") . 'laboratorios' => fn() => self::load('LaboratoriosController', 'viewLaboratorios'),
        getenv("DOM_URI") . 'laboratorio/{id}' => fn($id) => self::load('LaboratoriosController', 'monitorar', $id),

        //user
        getenv("DOM_URI") . 'logout' => fn() => self::load('UserController', 'logout'),

    ],

    'post' => [
        getenv("DOM_URI") . 'login' => fn() => self::load('LoginController', 'ProcessLogin'),
        getenv("DOM_URI") . 'matricula' => fn() => self::load('MatriculaController', 'SelecionarMatricula'),
        getenv("DOM_URI") . 'matricula/requisitar' => fn() => self::load('RequisitarController', 'RequisitarMatricula'),
        getenv("DOM_URI") . 'registrar' => fn() => self::load('RegistrarController', 'processRegistration'),
        getenv("DOM_URI") . 'requisicoes/matricula' => fn() => self::load('RequisicoesMatriculasController', 'setNovoStatusRequisicao'),
        getenv("DOM_URI") . 'requisicoes/projeto' => fn() => self::load('RequisicoesProjetosController', 'setNovoStatusRequisicao'),
        getenv("DOM_URI") . 'projetos' => fn() => self::load('ProjetosController', 'requisitarProjeto'),
        getenv("DOM_URI") . 'projetos/atualizar-participacao' => fn() => self::load('ProjetosController', 'atualizaParticipacao'),
        getenv("DOM_URI") . 'projetos/adicionar-atividade' => fn() => self::load('ProjetosController', 'adicionarAtividade'),
        getenv("DOM_URI") . 'projetos/listar-possiveis-integrantes/{id}' => fn($params) => self::load('ProjetosController', 'listarPossiveisIntegrantes', $params),
        getenv("DOM_URI") . 'projetos/adicionar-integrante/{id}' => fn($params) => self::load('ProjetosController', 'adicionarIntegrante', $params),
        getenv("DOM_URI") . 'projetos/alterar-tutor' => fn() => self::load('ProjetosController', 'alterarTutor'),
        getenv("DOM_URI") . 'projetos/listar-possiveis-projetos' => fn($params) => self::load('ProjetosController', 'listarPossiveisProjetos', $params),
        getenv("DOM_URI") . 'projetos/solicitar-participacao-projeto' => fn($params) => self::load('ProjetosController', 'solicitarParticipacao', $params),
        getenv("DOM_URI") . 'atualizar-atividade' => fn() => self::load('AcoesController', 'atualizarAtividade'),
        getenv("DOM_URI") . 'atividade/listar-possiveis-participantes/{id}' => fn($params) => self::load('AcoesController', 'listarPossiveisParticipantes', $params),
        getenv("DOM_URI") . 'atividade/adicionar-participante/{id}' => fn($params) => self::load('AcoesController', 'adicionarParticipante', $params),
        getenv("DOM_URI") . 'gerarGrafico' => fn() => self::load('DashboardController', 'gerarGrafico'),


    ],

    'put' => [
        getenv("DOM_URI") . 'finalizar-participacao/{id}' => fn($params) => self::load('ProjetosController', 'finalizarParticipacao', $params)


    ],

    'delete' => [
        getenv("DOM_URI") . 'atividade/remover-participacao' => fn() => self::load('AcoesController', 'removerParticipacao'),

    ],
];