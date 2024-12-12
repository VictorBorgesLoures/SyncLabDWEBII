<?php $this->layout('master', ['title' => 'SyncLab - Conectar']);
\cefet\SyncLab\classes\Session::set('active', 'login');
?>


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


<script type="module" text="javascript" src="/public/assets/js/Controllers/Login.js"></script>
