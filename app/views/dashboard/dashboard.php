<?php use cefet\SyncLab\classes\Session;

$this->layout('masterApp', ['title' => 'Dashboard']);
\cefet\SyncLab\classes\Session::set('active', 'dashboard');
/**
 * @var int $totalProjetos Total de projetos ativos
 * @var int $atvEmAndamento Total de atividades em andamento
 * @var int $atvConcluidas Total de atividades concluídas
 * @var int $totalReqMat Total de requisições concluídas
 * @var int $totalReqProj Total de requisições de projetos concluídas
 */


?>

<div id="main-content" class="main-content active">
    <h2>Bem vindo ao Dashboard SyncLab</h2>
    <div class="filter-chart">
        <div class="filter-chart-option">
            <input class="filter-option" type="checkbox" name="projetos" value="proj" checked />
            <label for="projetos">Projetos</label>
        </div>
        <div class="filter-chart-option">
            <input class="filter-option" type="checkbox" name="atividades" value="atv" />
            <label for="atividades">Atividades</label>
        </div>
        <div class="filter-chart-option">
            <input class="filter-option" type="checkbox" name="requisicoes" value="req" />
            <label for="requisicoes">Requisições</label>
        </div>
    </div>
    <div class="chart-box">
        <canvas id="myChart"></canvas>
    </div>

    <script src="/public/assets/js/lib/charts.js"></script>
    <?php if (Session::get('type') == 'admin') : ?>
        <div class="cards-container">
            <div class="card-box">
                <div class="card-title">
                    <h3>Requisições Matrícula</h3>
                </div>
                <div class="card-content">
                    <p>Você já concluiu <?=$totalReqMat?> requisições de matrícula!
                    </p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Requisições Projetos</h3>
                </div>
                <div class="card-content">
                    <p>Você já concluiu <?=$totalReqProj?> requisições de projetos!
                    </p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Projetos</h3>
                </div>
                <div class="card-content">
                    <p>Existem <?=$totalProjetos?> projetos ativos no momento! Veja <a href="/projetos">aqui</a>.
                    </p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Ações</h3>
                </div>
                <div class="card-content">
                    <p>Existem <?=$atvEmAndamento?> atividades em aberto no momento, <a href="/atividades">cheque aqui</a>.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="cards-container">
            <div class="card-box">
                <div class="card-title">
                    <h3>Projetos</h3>
                </div>
                <div class="card-content">
                    <p>Você está vinculado à <?=$totalProjetos?> projetos no momento! Veja <a href="/projetos">aqui</a>.
                    </p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Ações</h3>
                </div>
                <div class="card-content">
                    <p><?=$atvEmAndamento?> atividades estão em aberto, <a href="/atividades">cheque aqui</a>.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<script text="javascript" type="module"  src="/public/assets/js/Controllers/Dashboard.js"></script>