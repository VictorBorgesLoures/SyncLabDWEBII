<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Rota - SyncLAb</title>
    <link rel="stylesheet" href="/public/assets/styles/error.css" type="text/css">
</head>
<body>
<div class="error-container">
    <?php if (\cefet\SyncLab\classes\Session::has('__flash')) : ?>
        <div class="error-message">
            <p><strong>Detalhes do erro:</strong></p>
            <p><?php echo \cefet\SyncLab\classes\Session::messageFlash(); ?></p>
        </div>
    <?php endif; ?>
    <img src="/public/assets/images/undraw_page_not_found_re_e9o6.svg" alt="Not Found Image" style="max-width: 500px; height: auto; margin-bottom: 50px;"> <br>
    <h2>A Página que você tentou acessar não existe ou está indisponível.</h2>
    <a href="/">Voltar para a página inicial</a>
    <div class="contact-info">
        <p>Para mais assistência, envie um email para: <a href="mailto:contato@synclab.com.br">contato@synclab.com.br</a></p>
    </div>
</div>
</body>
</html>
