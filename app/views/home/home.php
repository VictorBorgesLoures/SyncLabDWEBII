<?php $this->layout('master', ['title' => 'SyncLab']);
\cefet\Adequa\classes\Session::set('active', 'home');
?>

<section class="home container">
    <h1 class="titulo">SyncLab</h1>
    <p class="introducao">O SyncLab surgiu para solucionar o problema das instituições de ensino
        na gerência de projetos e laboratórios, bem como contribuir na tomada
        de decisão das instituições através da análise de dados gerados através
        das diversas atividades executadas por professores e alunos!</p>
    <button class="botao2"><a href="/saiba-mais">Saiba Mais</a></button>
    <br>

    <img alt="ciclo Projeto Atividades Análises" class="graf" src="/public/assets/images/graf.webp">
</section>

<section class="container">

    <div class="titulo-secao">
        <h2 class="texto-escuro">Empresas que já contrataram nossos serviços</h2>
        <p class="texto-claro">Venha fazer parte também!</p>
    </div>

    <div class="caixa-comentarios">
        <div class="caixa-comentario">
            <p class="texto-escuro main-comment">"Ótimo para controle de atividades."</p>
            <div class="comentario-info">
                <div class="icon-user-container">
                    <img alt="icone placeholder" class="icon-user" src="/public/assets/images/okto-icon.jpeg"/>
                </div>
                <div>
                    <p class="texto-escuro user">Oktoplus</p>
                    <p class="texto-claro user-desc">Projeto de extensão de programação competitiva</p>
                </div>
            </div>
        </div>

        <div class="caixa-comentario">
            <p class="texto-escuro main-comment">"Facilitou a distribuição e registro de tarefas."</p>
            <div class="comentario-info">
                <div class="icon-user-container">
                    <img alt="icone placeholder" class="icon-user" src="/public/assets/images/pet-icon.jpeg"/>
                </div>
                <div>
                    <p class="texto-escuro user">PET-ECOMP</p>
                    <p class="texto-claro user-desc">Programa de educação tutorial</p>
                </div>
            </div>
        </div>

        <div class="caixa-comentario">
            <p class="texto-escuro main-comment">"Ficou muito mais fácil conseguir laboratórios."</p>
            <div class="comentario-info">
                <div class="icon-user-container">
                    <img alt="icone placeholder" class="icon-user" src="/public/assets/images/okto-gaming-icon.jpeg"/>
                </div>
                <div>
                    <p class="texto-escuro user">Oktoplus Gaming</p>
                    <p class="texto-claro user-desc">Projeto de extensão de e-sports</p>
                </div>
            </div>
        </div>

    </div>
</section>



