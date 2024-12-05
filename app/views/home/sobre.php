<?php $this->layout('master', ['title' => 'SyncLab - Sobre']);
\cefet\Adequa\classes\Session::set('active', 'sobre');
?>

<section class="sobremais container">
    <h1 class="titulo">Sobre</h1>
    <h2 class="subtitulo">Um sistema de gerenciamento de projetos</h2>
    <p>
        O SyncLab é um projeto que visa desenvolver um software voltado para gestão
        de laboratórios de pesquisa e desenvolvimento de quaisquer instituições.
        Laboratórios são lugares que geralmente possuem materiais valiosos, sejam eles de
        pesquisa ou os próprios aparelhos. Portanto, um monitoramento rígido desses lugares,
        saber quem entra e quem sai, quais pessoas têm acesso a chave,
        e também quem pode ter acesso ao sistema e se conectar a rede caso seja um laboratório
        de informática é importante. O propósito do SyncLab é justamente auxiliar nesse
        monitoramento.
    </p>
    <p>
        Para proporcionar um melhor entendimento das funcionalidades do Synclab,
        uma breve esplicação do estruturamento desse sistema é necessário.
    </p>
    <p>
        Começando pelo modelo de processo do sistema, temos como usuário inicial do sistema o Administrador
        que terá como ações Registrar um Docente, Discente ou outro Administrador
        no sistema, Criar Projetos que serão posteriormente delegados aos devidos
        orientadores, Gerenciar Requisições podendo visualizar o
        conteúdo e mudar os status, Gerenciar Laboratórios podendo acessar informações
        gerais dos laboratórios e, por fim, Acessar Informações dos Projetos que será
        um dashboard (painel de controle) administrativo apresentando os dados
        gerados pelo SyncLab de forma agregada.
    </p>
    <p>
        Já com os Docentes registrados no sistema, terão como ações Registrar Requisições,
        Gerenciar os Projetos e Atividades, bem como Registrar os Discentes nos projetos
        que administra.
    </p>
    <p>
        Ao registrar os Discentes no sistema, eles poderão executar a ação
        Contabilizar Horas em algum projeto.
    </p>
    <h2 class="subtitulo">Login e Registro</h2>
    <img alt="Diagrama Login" class="bpmn" src="/public/assets/images/login.png"/>

    <h2 class="subtitulo"> Projetos </h2>
    <img alt="Diagrama Projetos" class="bpmn" src="/public/assets/images/projetos.png"/>

    <h2 class="subtitulo"> Laboratório </h2>
    <img alt="Diagrama Laboratório" class="bpmn" src="/public/assets/images/laboratorio.png"/>

    <h2 class="subtitulo"> Requisições </h2>
    <img alt="Diagrama Requisições" class="bpmn" src="/public/assets/images/requisicao.png"/>

    <p>
        Além disso, foi desenvolvido o esquema do Banco de Dados do Synclab:
    </p>
    <img alt="DER" class="bpmn" src="/public/assets/images/der.jpg"/>
    <p>
        Esses foram os principais guias no sesenvolvimento do front-end do sistema SyncLab.
    </p>
    <br>
</section>

<footer class="rodape">
    <div class="container sub-rodape">
        <h2 class="titulo-rodape">
            SyncLab
        </h2>

        <div>
            <p class="subtitulo-rodape">Veja também: </p>
            <ul class="links-rodape">
                <li class="footlink"><a href="/home">home</a></li>
                <li class="footlink"><a href="/contato">contato</a></li>
                <li class="footlink"><a href="/sobre">sobre</a></li>
            </ul>
        </div>
    </div>
</footer>
