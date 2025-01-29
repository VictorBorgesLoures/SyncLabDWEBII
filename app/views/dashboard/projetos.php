<?php $this->layout('masterApp', ['title' => 'Projetos']);
\cefet\SyncLab\classes\Session::set('active', 'projetos');

/**
 * @var array $projetos Projetos que o usuário está vinculado.
 */

?>


<div id="main-content" class="main-content active">
    <?= $this->insert('includes/toasts') ?>
    <?php
    echo \cefet\SyncLab\classes\Session::messageFlash();
    if (\cefet\SyncLab\classes\Session::get('type') == 'docente') {
    ?>
        <form class="form" id="projeto-form">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Requisitar Projeto</h2>
            </div>
            <div class="form-group">
                <label class="label-box">Nome do Projeto:</label>
                <input class="input-box" id="nomeProj" name="nomeProj" type="text" placeholder="Digite o nome do novo projeto." />
            </div>
            <div class="form-group">
                <label class="label-box">Descrição do Projeto:</label>
                <textarea class="input-box" id="descricaoProj" name="descricaoProj" type="text" placeholder="Descreva em até 1000 caracteres o projeto." ></textarea>
            </div>
            <div class="text-end">
                <button class="login-btn mb-5" type="submit">Requisitar</button>
            </div>
        </form>
    <?php
    }
    ?>
    <?php if(\cefet\SyncLab\classes\Session::get('type') == 'discente'): ?>

            <div class="text-center mb-4">
                <h2 class="fw-bold">Requisitar Participação</h2>
            </div>
            <div class="container mt-5">
                <input type="text" id="searchInput" class="form-control" placeholder="Digite o nome do projeto...">
                <input type="hidden" id="idMat" value="<?= \cefet\SyncLab\classes\Session::get('idMat') ?>">
                <table class="tablecontent mt-4">
                    <thead>
                        <tr class="table-row">
                            <th>Nome</th>
                            <th>Tutor</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="results"></tbody>
                </table>
            </div>


    <?php endif; ?>

    <div class="text-center mb-4">
        <h2 class="fw-bold">Projetos</h2>
    </div>

    <table class="tablecontent">
        <thead>
            <tr class="table-row">
                <th class="table-head">Nome</th>
                <th class="table-head">Descrição</th>
                <th class="table-head">Status</th>
                <th class="table-head">Tutor</th>
                <th class="table-head">Criador</th>
                <th class="table-head">Data Criação</th>
                <th class="table-head">Gerenciar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($projetos as $projeto) : ?>
                <tr class="table-row">
                    <td class="table-data"><?= $projeto['nomeProj'] ?></td>
                    <td class="table-data"><?= $projeto['descricaoProj'] ?></td>
                    <td class="table-data"><?= $projeto['statusProj'] ?></td>
                    <td class="table-data"><?= $projeto['tutor'] ?></td>
                    <td class="table-data"><?= $projeto['criador'] ?></td>
                    <td class="table-data"><?= $projeto['dataCriacaoProj'] ?></td>
                    <td class="table-data">
                        <a href="projetos/<?= $projeto['idProj'] ?>">
                            <button type="button" class="btn-success">
                                <img class="table-svg-icon" src="/public/assets/images/pencil-file-svgrepo-com.svg" alt="edit">
                            </button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script text="javascript" type="module" src="/public/assets/js/Controllers/Projetos.js"></script>
<script text="javascript" type="module" src="/public/assets/js/scripts/searchProject.js"></script>