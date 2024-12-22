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

        //Projetos
        getenv("DOM_URI") . 'projetos' => fn() => self::load('ProjetosController', 'viewProjetos'),

        //Requisições
        getenv("DOM_URI") . 'requisicoes' => fn() => self::load('RequisicoesController', 'viewRequisicoes'),

        //Ações
        getenv("DOM_URI") . 'acoes' => fn() => self::load('AcoesController', 'viewAcoes'),

        //Laboratórios
        getenv("DOM_URI") . 'laboratorios' => fn() => self::load('LaboratoriosController', 'viewLaboratorios'),
        getenv("DOM_URI") . 'laboratorio/{id}' => fn($id) => self::load('LaboratoriosController', 'monitorar', $id),

        //user
        getenv("DOM_URI") . 'logout' => fn() => self::load('UserController', 'logout'),
    ],

    'post' => [
        getenv("DOM_URI") . 'login' => fn() => self::load('LoginController', 'ProcessaLogin'),
        getenv("DOM_URI") . 'registrar' => fn() => self::load('RegistrarController', 'processarRegistro'),


    ],

    'put' => [


    ],

    'delete' => [

    ],
];