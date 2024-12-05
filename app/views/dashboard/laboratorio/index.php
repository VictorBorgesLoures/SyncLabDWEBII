<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SyncLab</title>
    <link rel="stylesheet" href="../../styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="/dashboard/styles/styles.css" type="text/css"/>
</head>
<body class="body-fix">
    <nav class="navbar">
        <div id="sidebar-btn" class="logo-container">
            <img alt="SyncLab" src="../../images/logo-nome.png" class="navlogo logo-name"/>
            <img alt="logo do SyncLab" src="../../images/logo-ampulheta.png" class="navlogo ampulheta"/>
        </div>
        <ul class="navbuttons">
            <li class="dash-nav-option">Victor Borges</li>
            <li><a href="/login.html"><button class="navlink dash-nav-option botao">Sair</button></a></li>
        </ul>
    </nav>
    <aside id="side-navbar" class="side-bar active">
        <ul class="side-navbar">
            <li class="side-navbar-li"><a href="/dashboard/index.html" class="side-navbar-link">Dashboard</a></li>
            <li class="side-navbar-li"><a href="/dashboard/projetos.html" class="side-navbar-link">Projetos</a></li>
            <li class="side-navbar-li"><a href="/dashboard/requisicoes.html" class="side-navbar-link">Requisições</a></li>
            <li class="side-navbar-li"><a href="/dashboard/acoes.html" class="side-navbar-link">Ações</a></li>
            <li class="side-navbar-li active"><a href="/dashboard/laboratorio.html" class="side-navbar-link">Laboratórios</a></li>
        </ul>
    </aside>
    <div id="main-content" class="main-content active">
        <h2>Laboratório 6-115</h2>
        <div class="cards-container">
            <div class="card-box">
                <div class="card-title">
                    <h3>Status</h3>
                </div>
                <div class="card-content">
                    <p>Funcionando</p>
                </div>
            </div>
            <div class="card-box">
                <div class="card-title">
                    <h3>Pessoas - 7</h3>
                </div>
                <div class="card-content">
                    <p>Fulano</p>
                    <p>Beltrano</p>
                    <p>Ciclano</p>
                    <p>Furlane</p>
                    <p>Alonso</p>
                    <p>Arnold</p>
                    <p>Gilgamash</p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        sidebarIsOpen = true;
        window.onload = () => {
            document.getElementById("sidebar-btn").onclick = ( event => {
                event.preventDefault();                
                if(!sidebarIsOpen) {
                    document.getElementById("side-navbar").className = "side-bar active";
                    document.getElementById("main-content").className = "main-content active";
                    logoElements = document.getElementsByClassName("navlogo");
                    let length = logoElements.length;
                    for(let i=0; i < length; i++) {
                        element = logoElements[i];
                        classes = element.className.split(" ");
                        element.className = "";
                        for (let j = 0; j < classes.length-1; j++) {
                            element.className += " "+classes[j];
                        }
                    }
                } else {
                    document.getElementById("side-navbar").className = "side-bar";
                    document.getElementById("main-content").className = "main-content";
                    logoElements = document.getElementsByClassName("navlogo");
                    for(i=0; i < logoElements.length; i++) {
                        logoElements[i].className+= " active";
                    }
                }
                sidebarIsOpen=!sidebarIsOpen;
            });
        };
    </script>
</body>
</html>