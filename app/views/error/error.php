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
    <p>No momento, estamos enfrentando problemas técnicos ou realizando uma manutenção programada.</p>
    <p>Por favor, tente novamente mais tarde. Se o problema persistir, entre em contato conosco.</p>
    <?php if (\cefet\SyncLab\classes\Session::has('__flash')) : ?>
        <div class="error-message">
            <p><strong>Detalhes do erro:</strong></p>
            <p><?php echo \cefet\SyncLab\classes\Session::messageFlash(); ?></p>
        </div>
    <?php endif; ?>
    <a href="/">Voltar para a página inicial</a>
    <div class="contact-info">
        <p>Para mais assistência, envie um email para: <a href="mailto:contato@synclab.com.br">contato@synclab.com.br</a></p>
    </div>
</div>
</body>
</html>
