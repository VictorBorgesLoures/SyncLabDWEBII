<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - Adequa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #13203D;
            color: #D9D9D9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            padding: 20px;
            text-align: center;
            width: 100%;
        }
        .error-container h1 {
            color: #e74c3c;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .error-container p {
            font-size: 1.1em;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .error-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #13203D;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .error-container a:hover {
            background-color: #195905;
        }
        .contact-info {
            margin-top: 15px;
            font-size: 0.9em;
        }
        .contact-info a {
            color: #e74c3c;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>Ops! Algo deu errado.</h1>
    <p>No momento, estamos enfrentando problemas técnicos ou realizando uma manutenção programada.</p>
    <p>Por favor, tente novamente mais tarde. Se o problema persistir, entre em contato conosco.</p>
    <?php if (\cefet\Adequa\classes\Session::has('__flash')) : ?>
        <div class="error-message">
            <p><strong>Detalhes do erro:</strong></p>
            <p><?php echo \cefet\Adequa\classes\Session::messageFlash(); ?></p>
        </div>
    <?php endif; ?>
    <a href="/sistema">Voltar para a página inicial</a>
    <div class="contact-info">
        <p>Para mais assistência, envie um email para: <a href="mailto:contato@adequa.com.br">contato@adequa.com.br</a></p>
    </div>
</div>
</body>
</html>
