<?php $this->layout('master', ['title' => 'SyncLab - Conectar']);
\cefet\SyncLab\classes\Session::set('active', 'login');
?>

<section class="form-section container">
    <form class="form" id="login-form">
        <div class="text-center mb-4">
            <h1 class="fw-bold">Login</h1>
        </div>
        <?php echo \cefet\SyncLab\classes\Session::messageFlash() ?>
        <div class="form-group">
            <label class="label-box">Usuário:</label>
            <input class="input-box" id="username" name="username" type="text" placeholder="Digite seu nome de usuário"/>
        </div>
        <div class="form-group">
            <label class="label-box">Senha:</label>
            <input class="input-box" id="password" name="password" type="password" placeholder="Digite sua senha"/>
        </div>
        <div class="form-group">
            <a href="/registrar" class="btn btn-link">Não está registrado? Faça aqui seu registro.</a>
        </div>
        <div class="text-end">
            <button class="login-btn mb-5" type="submit">Entrar</button>
        </div>
    </form>

</section>


<script type="module" text="javascript" src="/public/assets/js/Controllers/Login.js"></script>
