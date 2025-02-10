<?php use cefet\SyncLab\classes\Session;
Session::set('active', 'projetos');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - SyncLab</title>
    <link rel="stylesheet" href="/public/assets/styles/error.css" type="text/css">
</head>
<body>
<div class="error-container">
    <h1>Ops! Algo deu errado.</h1>
    <p>Este projeto não foi encontrado.</p>
    <a href="/projetos">Voltar para a página de projetos</a>
    <div class="contact-info">
        <p>Para mais assistência, envie um email para: <a href="mailto:contato@synclab.com.br">contato@synclab.com.br</a></p>
    </div>
</div>
</body>
</html>
