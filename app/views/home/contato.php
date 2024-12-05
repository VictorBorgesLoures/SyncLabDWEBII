<?php $this->layout('master', ['title' => 'SyncLab - Contato']);
\cefet\Adequa\classes\Session::set('active', 'contato');
?>

<section class="contato container">
    <h1 class="titulo">Entre em contato</h1>
    <p>
        Entre em contato conosco para que possamos
        realizar um orçamento a fim de implementar o sistema na sua instituição!
    </p>
    <br>
    <div class="form-section">
        <form class="form" id="contato-form">
            <div class="form-group">
                <label class="label-box">Nome:</label>
                <input class="input-box" id="nome" type="text" placeholder="Digite o nome pessoa física ou jurídica"/>
            </div>
            <div class="form-group">
                <label class="label-box">Assunto:</label>
                <select class="input-box" id="assunto">
                    <option value="0">Selecione o assunto</option>
                    <option value="Orçamento">Orçamento</option>
                    <option value="SAC">SAC</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label-box">Comentário:</label>
                <textarea class="input-box" id="comentario" style="resize: none;" maxlength="1000" rows="8" cols="50" type="text-area" placeholder="Digite um texto breve sobre o assunto."></textarea>
            </div>
            <button class="login-btn" type="submit">Enviar</button>
        </form>
</section>

<script type="module" text="javascript" src="/public/assets/js/Controllers/Contato.js"></script>

