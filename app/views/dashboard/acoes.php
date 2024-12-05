<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SyncLab</title>
    <link rel="stylesheet" href="../styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="/dashboard/styles/styles.css" type="text/css"/>
</head>
<body class="body-fix">
    <nav class="navbar">
        <div id="sidebar-btn" class="logo-container">
            <img alt="SyncLab" src="../images/logo-nome.png" class="navlogo logo-name"/>
            <img alt="logo do SyncLab" src="../images/logo-ampulheta.png" class="navlogo ampulheta"/>
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
            <li class="side-navbar-li active"><a href="/dashboard/acoes.html" class="side-navbar-link">Ações</a></li>
            <li class="side-navbar-li"><a href="/dashboard/laboratorio.html" class="side-navbar-link">Laboratórios</a></li>
        </ul>
    </aside>
    <div id="main-content" class="main-content active">
        <table class="tablecontent">
            <thead>
                <tr class="table-row">
                    <th class="table-head">Nome do Projeto</th>
                    <th class="table-head">Atividade</th>
                    <th class="table-head">Atuantes</th>
                    <th class="table-head">Inicio</th>
                    <th class="table-head">Entrega</th>
                    <th class="table-head">Monitorar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-row">
                    <td class="table-data">Oktoplus - Programação Competitiva</td>
                    <td class="table-data">Produçao Minicurso de Introdução à Programação</td>
                    <td class="table-data">Victor, Wendell, Richard</td>
                    <td class="table-data">17-07-2024</td>
                    <td class="table-data">29-08-2024</td>
                    <td class="table-data"><img class="table-svg-icon" src="/images/paper-svgrepo-com.svg" ></td>
                </tr>
                <tr class="table-row">
                    <td class="table-data">Oktoplus - Programação Competitiva</td>
                    <td class="table-data">Atualizar Exercícios na Planilha</td>
                    <td class="table-data">Victor, Nicole</td>
                    <td class="table-data">23-07-2024</td>
                    <td class="table-data">10-08-2024</td>
                    <td class="table-data"><img class="table-svg-icon" src="/images/paper-svgrepo-com.svg" ></td>
                </tr>
                <tr class="table-row">
                    <td class="table-data">PET.COMP</td>
                    <td class="table-data">Definir Visita Técnica na Semana da Computação</td>
                    <td class="table-data">Victor</td>
                    <td class="table-data">04-08-2024</td>
                    <td class="table-data">23-08-2024</td>
                    <td class="table-data"><img class="table-svg-icon" src="/images/paper-svgrepo-com.svg" ></td>
                </tr>
                <tr class="table-row">
                    <td class="table-data">PET.COMP</td>
                    <td class="table-data">Produzir Minicurso React</td>
                    <td class="table-data">Victor</td>
                    <td class="table-data">01-08-2024</td>
                    <td class="table-data">18-10-2024</td>
                    <td class="table-data"><img class="table-svg-icon" src="/images/paper-svgrepo-com.svg" ></td>
                </tr>
            </tbody>
        </table>
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