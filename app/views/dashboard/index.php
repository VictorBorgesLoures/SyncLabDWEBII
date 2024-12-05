<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SyncLab</title>
    <link rel="stylesheet" href="../styles/style.css" type="text/css" />
    <link rel="stylesheet" href="/dashboard/styles/styles.css" type="text/css" />
</head>

<body class="body-fix">
    <nav class="navbar">
        <div id="sidebar-btn" class="logo-container">
            <img alt="SyncLab" src="../images/logo-nome.png" class="navlogo logo-name" />
            <img alt="logo do SyncLab" src="../images/logo-ampulheta.png" class="navlogo ampulheta" />
        </div>
        <ul class="navbuttons">
            <li class="dash-nav-option">Victor Borges</li>
            <li><a href="/login.html"><button class="navlink dash-nav-option botao">Sair</button></a></li>
        </ul>
    </nav>
    <aside id="side-navbar" class="side-bar active">
        <ul class="side-navbar">
            <li class="side-navbar-li active"><a href="/dashboard/index.html" class="side-navbar-link">Dashboard</a>
            </li>
            <li class="side-navbar-li"><a href="/dashboard/projetos.html" class="side-navbar-link">Projetos</a></li>
            <li class="side-navbar-li"><a href="/dashboard/requisicoes.html" class="side-navbar-link">Requisições</a>
            </li>
            <li class="side-navbar-li"><a href="/dashboard/acoes.html" class="side-navbar-link">Ações</a></li>
            <li class="side-navbar-li"><a href="/dashboard/laboratorio.html" class="side-navbar-link">Laboratórios</a>
            </li>
        </ul>
    </aside>
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

        <script src="../js/lib/charts.js"></script>
        <div class="cards-container">
            <div class="card-box">
                <div class="card-title">
                    <h3>Projetos</h3>
                </div>
                <div class="card-content">
                    <p>Você está vinculado à 3 projetos no momento! Veja <a href="/dashboard/projetos.html">aqui</a>.
                    </p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Ações</h3>
                </div>
                <div class="card-content">
                    <p>4 atividades estão em aberto, <a href="/dashboard/acoes.html">cheque aqui</a>.</p>
                </div>
            </div>
        </div>
    </div>
    <script text="javascript" type="module"  src="../js/Controllers/Dashboard.js"></script>
</body>

</html>