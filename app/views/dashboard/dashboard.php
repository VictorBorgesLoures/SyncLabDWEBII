<?php $this->layout('masterApp', ['title' => 'Dashboard']);
\cefet\SyncLab\classes\Session::set('active', 'dashboard');

/**
 * @var int $totalProjetos Quantidade de projetos que o usuário está vinculado.
 * @var int $totalAtividades Quantidade de atividades em aberto.
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
                <p><?=$totalAtividades?> atividades estão em aberto, <a href="/acoes">cheque aqui</a>.</p>
            </div>
        </div>
    </div>
</div>
<script text="javascript" type="module"  src="/public/assets/js/Controllers/Dashboard.js"></script>