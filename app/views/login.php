<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SyncLab - Login</title>
    <link rel="stylesheet" href="styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="styles/form.css" type="text/css"/>
</head>
<body class="body-fix">
    <nav class="navbar container">
        <img alt="logo do SyncLab" src="images/synclab img.webp" class="navlogo"/>
        <ul class="navbuttons">
            <li class="navlink"><a href="/index.html">home</a></li>
            <li class="navlink"><a href="/contato.html">contato</a></li>
            <li class="navlink"><a href="/sobre.html">sobre</a></li>
            <li><a href="/login.html"><button class="navlink botao ativo">conectar-se</button></a></li>
        </ul>
    </nav>

    <section class="form-section container">
        <form class="form" id="login-form">
            <div class="form-group">
                <label class="label-box">Usuário:</label>
                <input class="input-box" id="username" type="text" placeholder="Digite seu nome de usuário"/> 
            </div>
            <div class="form-group">
                <label class="label-box">Senha:</label>
                <input class="input-box" id="password" type="password" placeholder="Digite sua senha"/>
            </div>
                <button class="login-btn" type="submit" >Entrar</button>                
        </form>
    </section>

    <footer class="rodape">
        <div class="container sub-rodape">
            <h2 class="titulo-rodape">
                SyncLab
            </h2>
    
            <div>
                <p class="subtitulo-rodape">Veja também: </p>
                <ul class="links-rodape">
                    <li class="footlink"><a href="home.html">home</a></li>
                    <li class="footlink"><a href="contato.php">contato</a></li>
                    <li class="footlink"><a href="sobre.php">sobre</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script type="module" text="javascript" src="./js/Controllers/Login.js"></script>

</body>
</html>