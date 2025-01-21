<?php
$this->layout('master', ['title' => 'SyncLab - Registrar']);
?>

<section class="form-section mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form row g-4" id="registrar-form">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold">Criar uma conta Synclab</h1>
                    </div>
                    <?= \cefet\SyncLab\classes\Session::messageFlash()?>
                    <div class="form-group">
                        <label for="address" class="label-box">Rua</label>
                        <input type="text" class="input-box" id="address" name="address" placeholder="Digite o endereço">
                    </div>
                    <div class="form-group">
                        <label for="number" class="label-box">Número</label>
                        <input type="text" class="input-box" id="number" name="number" placeholder="Número da residência">
                    </div>
                    <div class="form-group">
                        <label for="cep" class="label-box">CEP</label>
                        <input type="text" class="input-box" id="cep" name="cep" placeholder="Digite o CEP">
                    </div>
                    <div class="form-group">
                        <label for="complement" class="label-box">Complemento</label>
                        <input type="text" class="input-box" id="complement" name="complement" placeholder="Complemento">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="label-box">Nome</label>
                        <input type="text" class="input-box" id="name" name="name" placeholder="Digite seu nome completo">
                    </div>
                     <div class="form-group">
                        <label for="data" class="label-box">Data de nasc.</label>
                        <input type="date" class="input-box" id="data" name="data">
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-box">Endereço de Email</label>
                        <input type="email" class="input-box" id="email" name="email" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="username" class="label-box">Username</label>
                        <input type="text" class="input-box" id="username" name="username" placeholder="Digite seu username">
                    </div>

                    <div class="form-group">
                        <label for="password" class="label-box">Senha</label>
                        <input type="password" class="input-box" id="password" name="password" placeholder="Digite sua senha">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password" class="label-box">Confirmação de senha</label>
                        <input type="password" class="input-box" id="confirm-password" name="confirm-password" placeholder="Confirme sua senha">
                    </div>
                    <div class="form-group">
                        <label for="cpf" class="label-box">CPF</label>
                        <input type="text" class="input-box" id="cpf" name="cpf" placeholder="Digite seu CPF">
                    </div>
                    <div class="text-end mt-3">
                        <button class="login-btn mb-5" type="submit">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script type="module" text="javascript" src="/public/assets/js/Controllers/Registrar.js"></script>




